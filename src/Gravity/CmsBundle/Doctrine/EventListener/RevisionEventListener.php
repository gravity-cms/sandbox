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
use Gravity\CmsBundle\Entity\Revision;
use Gravity\CmsBundle\Field\FieldManager;
use Gravity\CmsBundle\Routing\RouteBuilder;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class RevisionEventListener
 *
 * @package Gravity\CmsBundle\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RevisionEventListener implements EventSubscriber
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * RevisionEventListener constructor.
     *
     * @param FieldManager $fieldManager
     */
    public function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        // update edit dates
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if($entity instanceof FieldableEntity){
                $revision = new Revision();
                $revision->setClass(get_class($entity));
                $revision->setData(serialize($entity));
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

    public function postRemove(LifecycleEventArgs $args)
    {

    }
} 
