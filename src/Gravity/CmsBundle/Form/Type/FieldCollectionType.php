<?php

namespace Gravity\CmsBundle\Form\Type;

use Gravity\CmsBundle\Form\DataTransformer\FieldCollectionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldCollectionType
 *
 * @package Gravity\CmsBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCollectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FieldCollectionDataTransformer($options['field_options']));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(
            [
                'field',
                'field_options',
            ]
        );

        $resolver->setAllowedTypes(
            [
                'field'         => 'Gravity\CmsBundle\Field\FieldDefinitionInterface',
                'field_options' => 'array',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['field']    = $options['field'];
        $view->vars['limit']    = $options['field_options']['limit'];
        $view->vars['required'] = $options['field_options']['required'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }
} 
