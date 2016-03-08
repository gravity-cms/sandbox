<?php

namespace Gravity\MenuBundle\Admin;

use Gravity\MenuBundle\Menu\MenuManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MenuItemAdmin extends Admin
{
    /**
     * @var MenuManager
     */
    protected $menuManager;

    /**
     * @param MenuManager $menuManager
     */
    public function setMenuManager($menuManager)
    {
        $this->menuManager = $menuManager;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('menu')
            ->add('name')
            ->add('url')
            ->add('route');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('menu')
            ->add('name')
            ->add('url')
            ->add('route')
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
        $menuChoices = [];
        foreach ($this->menuManager->getMenus() as $name => $options) {
            $menuChoices[$name] = $options['label'];
        }

        $formMapper
            ->add(
                'menu',
                'choice',
                [
                    'choices'  => $menuChoices,
                    'required' => true,
                ]
            )
            ->add(
                'name',
                'text',
                [
                    'required' => true
                ]
            )
            ->add(
                'url',
                'text',
                [
                    'required' => false
                ]
            )
            ->add(
                'route',
                'text',
                [
                    'required' => false
                ]
            )
            ->add(
                'follow',
                'checkbox',
                [
                    'required' => false,
                ]
            )
            ->add(
                'target',
                'choice',
                [
                    'choices' => [
                        '_self'  => 'Same Window',
                        '_blank' => 'New Tab',
                    ],
                ]
            )
            ->add('parent', 'sonata_type_model_list', [

            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('menu')
            ->add('name')
            ->add('url')
            ->add('route')
            ->add('options');
    }
}
