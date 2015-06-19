<?php

namespace Gravity\CmsBundle\Field\Type\Text\Widget\Formatted;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FormattedWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Text\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $limit = $options['field_options']['limit'];
        $builder
            ->add(
                'text',
                'sonata_formatter_type',
                [

                    'event_dispatcher'     => $builder->getEventDispatcher(),
                    'format_field'         => 'format',
                    'source_field'         => 'text',
                    'source_field_options' => [
                        'attr' => ['class' => 'span10', 'rows' => 20]
                    ],
                    'listener'             => true,
                    'target_field'         => 'text',
                    'ckeditor_context'     => 'default',

                    'label'                => false,
                    'attr'                 => [
                        'data-limit' => $limit,
                    ],
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_text_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget';
    }
}
