<?php

namespace Gravity\CmsBundle\Field\Type\Choice\Widget\Select;

use Gravity\Component\Field\Field;
use Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer\ChoiceArrayToStringDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SelectWidgetForm
 *
 * @package Gravity\CmsBundle\Field\Type\Choice\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldSettings  = $options['field_options'];
        $widgetSettings = $options['widget_options'];

        // if the field is not multiple, we need to transform the data from an array format to a string format
//        if (!$fieldSettings['multiple']) {
//            $builder->addModelTransformer(new ChoiceArrayToStringDataTransformer());
//        }

        $builder
            ->add(
                'choice',
                'choice',
                [
                    'empty_data' => [],
                    'choices'    => $fieldSettings['choices'],
                    'multiple'   => $fieldSettings['multiple'],
                    'required'   => $fieldSettings['required'],
                    'expanded'   => $widgetSettings['expanded'] ? true : false,
                    'label'      => $fieldSettings['label']
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
                'widget_options' => [],
                'allow_add'      => true,
                'allow_delete'   => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_choice_widget_select';
    }
}
