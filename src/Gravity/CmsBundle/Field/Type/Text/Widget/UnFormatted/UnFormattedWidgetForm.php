<?php

namespace Gravity\CmsBundle\Field\Type\Text\Widget\UnFormatted;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UnFormattedWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Text\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldSettings  = $options['field_options'];
        $limit          = $fieldSettings['limit'];
        $widgetSettings = $options['widget_options'];

        if ($widgetSettings['multiline']) {
            $builder
                ->add(
                    'text',
                    'textarea',
                    [
                        'label' => false,
                        'attr'  => [
                            'class'      => 'form-control',
                            'data-limit' => $limit,
                        ],
                    ]
                );
        } else {
            $builder
                ->add(
                    'text',
                    $widgetSettings['type'],
                    [
                        'label' => false,
                        'attr'  => [
                            'class'      => 'form-control',
                            'data-limit' => $limit,
                        ],
                    ]
                );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\CoreBundle\Entity\FieldText',
            ]
        );
    }

    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_text_widget';
    }
}
