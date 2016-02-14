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
class RedirectType implements RouteTypeInterface
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
        return $route->getDefault('_controller') === $this->routeController && $route->getDefault('path') !== '';
    }

    public function buildForm(AdminInterface $admin, FormMapper $formMapper)
    {
        /**
         * Bind data to the mapped fields
         */
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $formEvent) {
                $data = $formEvent->getData();
                $form = $formEvent->getForm();

                if ($data instanceof Route) {
                    $form->get('source')->setData($data->getPath());
                    $form->get('target')->setData($data->getDefault('path'));
                }
            }
        );

        /**
         * Bind the mapped fields to the entity
         */
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $formEvent) {
                $data = $formEvent->getData();
                $form = $formEvent->getForm();

                if ($data instanceof Route) {
                    $data->setStaticPrefix(
                        $form->get('source')->getData()
                    );
                    $data->setDefault('path', $form->get('target')->getData());
                    $data->setDefault('_controller', $this->routeController);
                    $data->setDefault('permanent', true);
                }
            }
        );

        $formMapper->add(
            'source',
            'text',
            [
                'mapped' => false,
            ]
        );
        $formMapper->add(
            'target',
            'text',
            [
                'mapped' => false,
            ]
        );
        $formMapper->remove('staticPrefix');
        $formMapper->remove('variablePattern');
    }
}
