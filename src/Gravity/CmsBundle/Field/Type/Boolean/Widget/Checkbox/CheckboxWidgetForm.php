<?php

namespace Gravity\CmsBundle\Field\Type\Boolean\Widget\Checkbox;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CheckboxWidgetForm
 *
 * @package Gravity\CmsBundle\Field\Type\Boolean\Widget\Checkbox
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CheckboxWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field         = $options['field'];
        $fieldSettings = $options['field_options'];
        $limit         = $fieldSettings['limit'];

        $builder
            ->add(
                'value',
                'checkbox',
                [
                    'label' => false,
                    'attr'  => [
                        'data-limit' => $limit,
                    ],
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
        return 'gravity_field_boolean_widget_checkbox';
    }
}
