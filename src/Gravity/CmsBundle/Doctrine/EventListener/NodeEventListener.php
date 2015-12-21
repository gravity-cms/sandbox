<?php

namespace Gravity\CmsBundle\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Gravity\CmsBundle\Entity\FieldableEntity;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Routing\RouteBuilder;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class NodeEventListener
 *
 * @package Gravity\CmsBundle\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeEventListener implements EventSubscriber
{
    /**
     * @var RouteBuilder
     */
    protected $routeBuilder;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param RouteBuilder          $routeBuilder
     */
    function __construct(TokenStorageInterface $tokenStorage, RouteBuilder $routeBuilder)
    {
        $this->routeBuilder = $routeBuilder;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
            Events::prePersist,
            Events::postPersist,
            Events::postRemove,
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        // update any routes
        $this->updateRouting($em, $uow);

        // update edit dates
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof FieldableEntity) {
                $user = $this->tokenStorage->getToken()->getUser();
                $entity->setEditedBy($user);
                $entity->setEditedOn(new \DateTime());
                $this->recomputeSingleEntityChangeSet($em, $entity);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em     = $args->getEntityManager();
        if ($entity instanceof Node) {
            if(!$entity->getRoute() instanceof Route){
                $route = $this->getNodeRoute($entity);
                $entity->setRoute($route);
                $em->flush();
            }
        }
    }


    /**
     * On pre-persist, set the createdBy and CreatedOn fields
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof FieldableEntity) {
            if (!$entity->getCreatedBy()) {
                $user = $this->tokenStorage->getToken()->getUser();
                $entity->setCreatedBy($user);
            }

            if (!$entity->getCreatedOn()) {
                $entity->setCreatedOn(new \DateTime());
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em     = $args->getEntityManager();

        if ($entity instanceof Node) {
            $route = $entity->getRoute();

            if (!$route instanceof Route) {
                $route = $this->getNodeRoute($entity);  // make a new route
                $this->deletedRoute($route);            // 410 the new route

                $entity->setRoute($route);
                $em->persist($route);
                $em->flush($route);
            } else {
                $this->deletedRoute($route);
                $em->persist($route);
                $em->flush($route);
            }
        }
    }

    public function postSoftDelete(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em     = $args->getEntityManager();
        $uow    = $em->getUnitOfWork();

        if ($entity instanceof Node) {
            if ($entity->getDeletedOn() instanceof \DateTime) {
                $route = $entity->getRoute();

                if (!$route instanceof Route) {
                    $route = $this->getNodeRoute($entity);  // make a new route
                    $this->deletedRoute($route);            // 410 the new route

                    $entity->setRoute($route);
                    $this->computeChangeSet($em, $route);

                    $uow->propertyChanged($entity, 'route', null, $route);
                    $uow->scheduleExtraUpdate(
                        $entity,
                        [
                            'route' => [null, $route]
                        ]
                    );
                } else {
                    $this->deletedRoute($route);
                    $this->recomputeSingleEntityChangeSet($em, $route);
                }

                $this->recomputeSingleEntityChangeSet($em, $entity);
            }
        }

    }

    /**
     * Schedule updates for routing
     *
     * @param EntityManager $em
     * @param UnitOfWork    $uow
     */
    protected function updateRouting(EntityManager $em, UnitOfWork $uow)
    {
        // 302 old routes to the new 200
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Node) {
                $changeSet = $uow->getEntityChangeSet($entity);

                $oldRoute = $entity->getRoute();

                // Check if we have a route. If not, create one and continue
                if (!$oldRoute instanceof Route) {
                    // create the new route
                    $oldRoute = $this->getNodeRoute($entity);

                    $entity->setRoute($oldRoute);
                    $this->computeChangeSet($em, $oldRoute);
                    $this->recomputeSingleEntityChangeSet($em, $entity);
                }

                // Check if the route has been manually updated
                $newRoute = $this->getNodeRoute($entity);

                // if the route changed, update it
                if ($newRoute->getPath() !== $oldRoute->getPath()) {
                    // create the new route entity
                    $entity->setRoute($newRoute);
                    $this->computeChangeSet($em, $newRoute);

                    // set any old route to redirect to the new route
                    $this->redirectRoute($oldRoute);
                    $this->recomputeSingleEntityChangeSet($em, $oldRoute);
                }

                if (isset($changeSet['deletedOn'])) {
                    if ($changeSet['deletedOn'] instanceof \DateTime) {
                        // delete
                        $this->deletedRoute($oldRoute);
                        $this->recomputeSingleEntityChangeSet($em, $oldRoute);
                    } else {
                        // un-delete
                        $newRoute = $this->getNodeRoute($entity);
                        $entity->setRoute($newRoute);
                        $uow->scheduleForDelete($oldRoute);

                        $this->computeChangeSet($em, $newRoute);
                        $this->recomputeSingleEntityChangeSet($em, $oldRoute);
                    }
                }

                $em->persist($entity);
                $this->recomputeSingleEntityChangeSet($em, $entity);
            }
        }
    }

    /**
     * Create a 200 route for a new Node
     *
     * @param Node $node
     *
     * @return Route
     */
    protected function getNodeRoute(Node $node)
    {
        return $this->routeBuilder->build($node);
    }

    /**
     * Redirect a route to a new url
     *
     * @param Route  $route
     *
     * @return \Symfony\Component\Routing\Route
     */
    protected function redirectRoute(Route $route)
    {
        $route->setDefault('_controller', 'GravityCmsBundle:Node:redirect');
    }

    /**
     * Create a 410 route
     *
     * @param Route $route
     *
     * @return Route
     */
    protected function deletedRoute(Route $route)
    {
        return $this->redirectRoute($route, '');
    }

    /**
     * Compute the changeset of a new entity
     *
     * @param EntityManager $em
     * @param object        $entity
     */
    protected function computeChangeSet(EntityManager $em, $entity)
    {
        $em->persist($entity);
        $em->getUnitOfWork()->computeChangeSet($em->getClassMetadata(get_class($entity)), $entity);
    }

    /**
     * Compute the change set for an existing single entity
     *
     * @param EntityManager $em
     * @param object        $entity
     */
    protected function recomputeSingleEntityChangeSet(EntityManager $em, $entity)
    {
        $em->persist($entity);
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
    }
} 
