<?php


namespace Gravity\CmsBundle\Field\Type\Boolean\Display;

use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Entity\FieldBoolean;
use Gravity\CmsBundle\Field\AbstractFieldDisplayDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Boolean\BooleanField;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BooleanDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class BooleanDisplay extends AbstractFieldDisplayDefinition
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'boolean';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Boolean';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @param Field|FieldBoolean $entity
     * @param array              $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'value' => $entity->getValue() === $options['true_value'] ? $options['true_value'] : $options['false_value'],
        ];
    }


    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setDefaults(
            [
                'true_value'  => 'True',
                'false_value' => 'False'
            ]
        );
    }


    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof BooleanField;
    }

}
