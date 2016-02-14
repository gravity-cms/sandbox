<?php

namespace Gravity\CmsBundle\Admin;

use Gravity\CmsBundle\Routing\Type\RouteTypeInterface;
use Gravity\CmsBundle\Routing\Type\RouteTypePool;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;

class RouteAdmin extends Admin
{
    /**
     * @var RouteTypePool
     */
    protected $routeTypePool;

    /**
     * @return RouteTypePool
     */
    public function getRouteTypePool()
    {
        return $this->routeTypePool;
    }

    /**
     * @param RouteTypePool $routeTypePool
     */
    public function setRouteTypePool(RouteTypePool $routeTypePool)
    {
        $this->routeTypePool = $routeTypePool;
    }

    /**
     * @inheritDoc
     */
    public function getPersistentParameters()
    {
        $parameters               = parent::getPersistentParameters();
        $parameters['route_type'] = $this->getRequest()->get('route_type');

        return $parameters;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('host')
            ->add('staticPrefix')
            ->add('variablePattern');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'staticPrefix',
                null,
                [
                    'label' => 'Route'
                ]
            )
            ->add('name')
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show'   => [],
                        'edit'   => [],
                        'delete' => [],
                    ]
                ]
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'name',
                'text',
                [

                ]
            )
            ->add(
                'host',
                'text',
                [
                    'required' => false,
                ]
            )
            ->add('staticPrefix')
            ->add('variablePattern');

        $routeType = $this->getPersistentParameter('route_type');

        if ($routeType) {
            $routeType = $this->routeTypePool->getRouteType(
                $routeType
            );
        } else {
            $object = $this->getSubject();
            if ($object instanceof Route) {
                foreach ($this->routeTypePool->getRouteTypes() as $name => $type) {
                    if ($type->supportsRoute($object)) {
                        $routeType = $type;
                        break;
                    }
                }
            }
        }

        if ($routeType instanceof RouteTypeInterface) {
            $routeType->buildForm($this, $formMapper);
        }

    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('staticPrefix')
            ->add('variablePattern');
    }
}
