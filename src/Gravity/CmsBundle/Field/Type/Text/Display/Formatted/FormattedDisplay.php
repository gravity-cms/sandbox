<?php


namespace Gravity\CmsBundle\Field\Type\Text\Display\Formatted;

use Gravity\CmsBundle\Display\Type\AbstractDisplayDefinition;
use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Entity\FieldText;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;

/**
 * Class FormattedDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedDisplay extends AbstractDisplayDefinition
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'text.formatted';
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'Formatted Text';
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return 'Output in formatted html';
    }

    /**
     * @param Field|FieldText $entity
     * @param array           $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'value' => $entity->getText(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field->getName() === 'text';
    }
}
