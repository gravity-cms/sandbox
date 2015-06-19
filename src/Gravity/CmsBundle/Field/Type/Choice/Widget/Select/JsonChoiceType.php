<?php


namespace Gravity\CmsBundle\Field\Type\Choice\Widget\Select;

use Gravity\CmsBundle\Field\Type\Choice\Widget\Select\DataTransformer\ChoiceArrayToStringDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class JsonChoiceType
 *
 * @package Gravity\CmsBundle\Field\Type\Choice\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class JsonChoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!$options['multiple']) {
            $builder->addModelTransformer(new ChoiceArrayToStringDataTransformer());
        }
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'json_choice';
    }

    public function getParent()
    {
        return 'choice';
    }

}
