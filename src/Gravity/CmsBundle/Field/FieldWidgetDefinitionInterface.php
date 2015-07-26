<?php


namespace Gravity\CmsBundle\Field;

use Gravity\CmsBundle\Asset\AssetLibraryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface FieldWidgetDefinitionInterface
 *
 * @package Gravity\CmsBundle\Field
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldWidgetDefinitionInterface
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
     * @param FormMapper               $formMapper
     * @param FieldDefinitionInterface $fieldDefinition
     * @param string                   $field
     * @param array                    $fieldOptions
     * @param string                   $widget
     * @param array                    $widgetOptions
     *
     * @return
     */
    public function configureForm(
        FormMapper $formMapper,
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    );

    /**
     * Get a list of asset libraries to use
     *
     * @param array $options
     *
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries(array $options);

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
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver);
}
