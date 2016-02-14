<?php


namespace Gravity\CmsBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RouteController
 *
 * @package Gravity\CmsBundle\Controller\Admin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RouteController extends CRUDController
{
    public function createAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $parameters = $this->admin->getPersistentParameters();

        $routeTypes = $this->admin->getRouteTypePool()->getRouteTypes();

        if (!isset($parameters['route_type'])) {
            return $this->render(
                'GravityCmsBundle:Route:create_select_route_type.html.twig',
                [
                    'route_types'   => $routeTypes,
                    'base_template' => $this->getBaseTemplate(),
                    'admin'         => $this->admin,
                    'action'        => 'create',
                ]
            );
        }

        return parent::createAction();
    }
}
