<?php

namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class GravityMediaWidgetForm
 *
 * @package Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityMediaWidgetForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'media',
                'hidden_entity',
                [
                    'class' => $options['field_options']['entity']
                ]
            )
            ->add('title', 'text')
            ->add('alt', 'text');
    }

    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['provider']         = $options['field_options']['provider'];
        $view->vars['provider_context'] = $options['field_options']['provider_context'];
        $view->vars['image_preview']    = $options['widget_options']['image_preview'];
    }

    /**
     * @inheritDoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'context'       => 'default',
                'provider'      => '',
                'class_class'   => 'Gravity\MediaBundle\Entity\FieldMedia',
                'label'         => null,
                'image_preview' => 'admin',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'gravity_media_widget_form';
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'field_widget';
    }

}
