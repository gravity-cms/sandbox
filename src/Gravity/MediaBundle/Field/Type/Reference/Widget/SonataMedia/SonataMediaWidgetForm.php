<?php

namespace Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SonataMediaWidgetForm
 *
 * @package Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SonataMediaWidgetForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'media',
                'sonata_media_type',
                [
                    'context'    => $options['field_options']['provider_context'],
                    'provider'   => $options['field_options']['provider'],
                    'data_class' => $options['field_options']['entity'],
                    'required' => false,
                ]
            )
            ->add('title', 'text')
            ->add('alt', 'text');
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
        return 'sonata_media_widget_form';
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'field_widget';
    }

}
