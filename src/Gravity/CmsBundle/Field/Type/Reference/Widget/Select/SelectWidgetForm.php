<?php

namespace Gravity\CmsBundle\Field\Type\Reference\Widget\Select;

use Symfony\Component\Form\AbstractType;
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'allow_add'    => true,
                'allow_delete' => true,
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
