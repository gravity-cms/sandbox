<?php


namespace Gravity\TagBundle\Field\Type\Reference\Display;

use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Field\AbstractFieldDisplayDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;

/**
 * Class TaxonomyListDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class TaxonomyListDisplay extends AbstractFieldDisplayDefinition
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'taxonomy_list';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'List of taxonomies';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getTemplate()
    {
        return 'GravityTagBundle:Field:taxonomy-list.html.twig';
    }

    /**
     * @param array $entity
     * @param array $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'tag' => $entity,
        ];
    }


    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof ReferenceField;
    }

}
