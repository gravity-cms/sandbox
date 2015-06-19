<?php

namespace Gravity\CmsBundle\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\FieldManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class NodeAdmin extends Admin
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @return FieldManager
     */
    public function getFieldManager()
    {
        return $this->fieldManager;
    }

    /**
     * @param FieldManager $fieldManager
     */
    public function setFieldManager($fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getNewInstance()
    {
        /** @var Node $entity */
        $className     = $this->getClass();
        $entity        = new $className();
        $fieldMappings = $this->fieldManager->getEntityFieldMapping($this->getClass());

        $optionsResolver = $this->fieldManager->createFieldOptionsResolver();

        foreach ($fieldMappings as $field => $fieldMapping) {
            $fieldDefinition = $this->fieldManager->getFieldDefinition($fieldMapping['type']);

            $fieldDefinition->setOptions($optionsResolver);
            $resolvedOptions = $optionsResolver->resolve($fieldMapping['options']);

            if ($fieldMapping['dynamic'] && $resolvedOptions['limit'] == 1) {
                $fieldClass = $fieldDefinition->getEntityClass();
                $entity->{"set{$field}"}(
                    [new $fieldClass()]
                );
            }

        }

        return $entity;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'GravityCmsBundle:Node:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('published')
            ->add('publishedFrom')
            ->add('publishedTo')
            ->add('createdOn')
            ->add('editedOn')
            ->add('deletedOn');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('published')
            ->add('publishedFrom')
            ->add('publishedTo')
            ->add('createdOn')
            ->add('editedOn')
            ->add('deletedOn')
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
            ->with('Content', ['class' => 'col-md-9'])->end()
            ->with('Publishing', ['class' => 'col-md-3'])->end()
            ->with('Routing', ['class' => 'col-md-3'])->end();

        $formMapper->with('Content')
            ->add('title');

        $fieldMappings = $this->fieldManager->getEntityFieldMapping($this->getClass());

        foreach ($fieldMappings as $field => $settings) {
            $fieldDefinition       = $this->fieldManager->getFieldDefinition($settings['type']);
            $fieldWidgetDefinition = $this->fieldManager->getFieldWidgetDefinition($settings['widget']['type']);

            $constraints = $fieldDefinition->getConstraints($field, $settings['options']);

            if ($settings['dynamic']) {
                $fieldWidgetDefinition->configureForm(
                    $formMapper,
                    $fieldDefinition,
                    $field,
                    $settings['options'],
                    $settings['widget']['options']
                );

                $formMapper->getFormBuilder()->addEventListener(
                    FormEvents::PRE_SET_DATA,
                    function (FormEvent $formEvent) use ($fieldDefinition, $field, $settings) {
                        $data = $formEvent->getData();

                        if ($data instanceof Node) {
                            $value = $data->{"get{$field}"}();
                            if (!$value || !count($value) && $settings['options']['limit'] == 1) {
                                $fieldClass = $fieldDefinition->getEntityClass();
                                $data->{"set{$field}"}(
                                    new ArrayCollection(
                                        [
                                            new $fieldClass(),
                                        ]
                                    )
                                );
                            }
                        }
                    }
                );
            } else {
                $fieldWidgetDefinition->configureForm(
                    $formMapper,
                    $field,
                    $settings['options'],
                    $settings['widget']['options']
                );

                /** @var ClassMetadata $metadata */
                $metadata = $this->validator->getMetadataFactory()->getMetadataFor($this->getClass());

                foreach ($constraints as $constraintField => $constraint) {
                    $metadata->addPropertyConstraints($constraintField, $constraint);
                }
            }
        }
        $formMapper->end();

        $formMapper->with('Publishing')
            ->add(
                'published',
                'checkbox',
                [
                    'required' => false,
                ]
            )
            ->add(
                'publishedFrom',
                'sonata_type_datetime_picker',
                [
                    'required' => false,
                ]
            )
            ->add(
                'publishedTo',
                'sonata_type_datetime_picker',
                [
                    'required' => false,
                ]
            )
            ->end();


        $formMapper->with('Routing')
            ->add('customPath', 'text', [
                'required' => false,
            ])
            ->setHelps([
                'customPath' => 'Set a custom path',
            ])
        ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('published')
            ->add('publishedFrom')
            ->add('publishedTo')
            ->add('createdOn')
            ->add('editedOn')
            ->add('deletedOn');
    }

    /**
     * @param Node $object
     *
     * @return void
     */
    public function prePersist($object)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$object->getId()) {
            $object->setCreatedBy($user);
            $object->setCreatedOn(new \DateTime());
        }

        $object->setEditedBy($user);
        $object->setEditedOn(new \DateTime());
    }

    public function preUpdate($object)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $object->setEditedBy($user);
        $object->setEditedOn(new \DateTime());
    }


}
