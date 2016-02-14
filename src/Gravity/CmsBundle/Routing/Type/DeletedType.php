<?php


namespace Gravity\CmsBundle\Routing\Type;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class RedirectType
 *
 * @package Gravity\CmsBundle\Routing\Types
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class DeletedType implements RouteTypeInterface
{

    /**
     * @var string
     */
    protected $routeController = 'FrameworkBundle:Redirect:urlRedirect';

    /**
     * @inheritDoc
     */
    public function supportsRoute(Route $route)
    {
        return $route->getDefault('_controller') === $this->routeController && $route->getDefault('path') === '';
    }

    public function buildForm(AdminInterface $admin, FormMapper $formMapper)
    {
        /**
         * Bind the mapped fields to the entity
         */
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $formEvent) {
                $data = $formEvent->getData();
                $form = $formEvent->getForm();

                if ($data instanceof Route) {
                    $data->setDefault('_controller', $this->routeController);
                    $data->setDefault('permanent', true);
                    $data->setDefault('path', '');
                }
            }
        );
    }
}
