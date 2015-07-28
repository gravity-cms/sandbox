<?php

namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

use Symfony\Component\Form\AbstractType;
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'label' => null
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
        return 'hidden_entity';
    }

}
