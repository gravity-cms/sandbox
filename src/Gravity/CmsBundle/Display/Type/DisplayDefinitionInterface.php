<?php


namespace Gravity\CmsBundle\Display\Type;

use Gravity\CmsBundle\Asset\AssetLibraryInterface;
use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface DisplayDefinitionInterface
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
interface DisplayDefinitionInterface
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
     *
     * @return string
     */
    public function getName();

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get a list of asset libraries to use
     *
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param Field $entity
     * @param array $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options);

    /**
     * @return string
     */
    public function getListTemplate();

    /**
     * @param array $entities
     * @param array $options
     *
     * @return array
     */
    public function getListTemplateOptions($entities, array $options);

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field);

    /**
     * @param OptionsResolver $optionsResolver
     * @param array           $options
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = []);
}
