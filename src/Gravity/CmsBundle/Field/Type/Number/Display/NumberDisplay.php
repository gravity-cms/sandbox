<?php


namespace Gravity\CmsBundle\Field\Type\Number\Display;

use Gravity\CmsBundle\Display\Type\AbstractDisplayDefinition;
use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Entity\FieldNumber;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Number\NumberField;

/**
 * Class NumberDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class NumberDisplay extends AbstractDisplayDefinition
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'number';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Number';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @param Field|FieldNumber $entity
     * @param array             $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'value' => $entity->getNumber(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof NumberField;
    }

}
