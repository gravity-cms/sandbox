<?php

namespace Gravity\CmsBundle\Field\Type\Number\Widget\NumberBox;

use Gravity\Component\Field\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Class NumberBoxWidgetForm
 *
 * @package Gravity\CmsBundle\Field\Type\Number\Widget\NumberBox
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NumberBoxWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldConfig = $options['field_options'];
        $limit       = $fieldConfig['limit'];

        $builder
            ->add(
                'number',
                'number',
                [
                    'label'       => false,
                    'attr'        => [
                        'class'      => 'form-control',
                        'data-limit' => $limit,
                        'step'       => $fieldConfig['step'],
                        'min'        => $fieldConfig['min'],
                        'max'        => $fieldConfig['max'],
                    ],
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\CoreBundle\Entity\FieldNumber',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_number_widget_numberbox';
    }
}

