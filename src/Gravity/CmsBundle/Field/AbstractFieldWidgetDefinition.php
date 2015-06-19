<?php


namespace Gravity\CmsBundle\Field;

use Gravity\CmsBundle\Asset\AssetLibraryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractFieldWidgetDefinition
 *
 * @package Gravity\CmsBundle\Field
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractFieldWidgetDefinition implements FieldWidgetDefinitionInterface
{
    /**
     * @param FormMapper               $formMapper
     * @param FieldDefinitionInterface $fieldDefinition
     * @param string                   $field
     * @param array                    $options
     * @param array                    $widgetOptions
     *
     * @return void
     */
    public function configureForm(
        FormMapper $formMapper,
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $options = [],
        array $widgetOptions = []
    ) {
        $isMultiple = $options['limit'] > 1 || $options['limit'] < 0;

        $formMapper->add(
            $field,
            'field_collection',
            [
                'type'          => $this->getForm(),
                'options'       => [
                    'label'          => false,
                    'field'          => $fieldDefinition,
                    'field_options'  => $options,
                    'widget_options' => $widgetOptions,
                    'data_class'     => $fieldDefinition->getEntityClass(),
                ],
                'field'         => $fieldDefinition,
                'field_options' => $options,
                'allow_add'     => $isMultiple,
                'allow_delete'  => $isMultiple,
                'by_reference'  => false,
            ]
        );
    }

    /**
     * Get a list of asset libraries to use
     *
     * @param array $options
     *
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries(array $options)
    {
        return [];
    }

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
    }

}
