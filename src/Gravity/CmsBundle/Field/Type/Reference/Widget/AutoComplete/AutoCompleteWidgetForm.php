<?php


namespace Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete;

use Symfony\Component\Form\AbstractType;

/**
 * Class AutoCompleteWidgetForm
 *
 * @package Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'auto_complete';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_choice_widget_autocomplete';
    }
}
