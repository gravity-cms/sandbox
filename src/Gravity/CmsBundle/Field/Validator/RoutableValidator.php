<?php


namespace Gravity\CmsBundle\Field\Validator;

use Doctrine\ORM\EntityManager;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Routing\NodeRouteManager;
use Gravity\CmsBundle\Routing\RouteBuilder;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class RoutableValidator
 *
 * @package Gravity\CmsBundle\Field\Validator
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RoutableValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NodeRouteManager
     */
    protected $nodeRouteManager;

    /**
     * @var RouteBuilder
     */
    protected $routeBuilder;

    /**
     * @param EntityManager    $entityManager
     * @param NodeRouteManager $nodeRouteManager
     * @param RouteBuilder     $routeBuilder
     */
    function __construct(EntityManager $entityManager, NodeRouteManager $nodeRouteManager, RouteBuilder $routeBuilder)
    {
        $this->entityManager    = $entityManager;
        $this->nodeRouteManager = $nodeRouteManager;
        $this->routeBuilder     = $routeBuilder;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Node) {
            $this->context->addViolation('Attempt to validate non Node entity');

            return;
        }

        $uow          = $this->entityManager->getUnitOfWork();
        $originalData = $uow->getOriginalEntityData($value);

        // If we've been given a custom path, then don't use nonConflict in route path generation
        $hasCustomPath = strlen($value->getPath());
        $route         = $this->routeBuilder->build($value, !$hasCustomPath);
        $routeName     = $this->routeBuilder->buildRouteName($route);

        if (is_array($originalData) && count($originalData)) {
            if ($originalData['path'] !== $value->getPath()) {
                $existingRoute =
                    $this->entityManager->getRepository('CmfRoutingBundle:Route')->findOneByName($routeName);
                if ($existingRoute instanceof Route) {
                    $this->context->buildViolation("A page at path '{$route->getPath()}' already exists")
                        ->atPath('path')
                        ->addViolation();

                    return;
                }
            } elseif ($value->getRoute() instanceof Route && $value->getRoute()->getName() !== $routeName) {
                $existingRoute =
                    $this->entityManager->getRepository('CmfRoutingBundle:Route')->findOneByName($routeName);
                if ($existingRoute instanceof Route) {
                    $this->context->buildViolation("A page at path '{$route->getPath()}' already exists")
                        ->atPath('path')
                        ->addViolation();

                    return;
                }
            }
        }
    }


}
