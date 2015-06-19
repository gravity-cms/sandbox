<?php


namespace Gravity\CmsBundle\Form\Type;

use Gravity\CmsBundle\Field\Validator\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class FieldWidgetType
 *
 * @package Gravity\CmsBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldWidgetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'delta',
            'hidden',
            [
                'empty_data' => 0,
            ]
        );
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
                'widget_options',
            ]
        );
        $resolver->setAllowedTypes(
            [
                'field'          => 'Gravity\CmsBundle\Field\FieldDefinitionInterface',
                'field_options'  => 'array',
                'widget_options' => 'array',
            ]
        );

        $resolver->setDefaults(
            [
                'constraints' => function (Options $options) {

                    /** @var \Gravity\CmsBundle\Field\FieldDefinitionInterface $field */
                    $constraints = [
                        new Field(
                            [
                                'fields' => $options['field']->getConstraints('', $options['field_options']),
                            ]
                        )
                    ];

                    if ($options['field_options']['required']) {
                        $constraints[] = new NotNull();
                    }

                    return $constraints;
                }
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_widget';
    }
}
