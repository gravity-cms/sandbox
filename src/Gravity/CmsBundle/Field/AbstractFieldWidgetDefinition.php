<?php


namespace Gravity\CmsBundle\Field;

use Gravity\CmsBundle\Asset\AssetLibraryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\AbstractType;
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
     * Get the form type for the widget
     *
     * @return AbstractType|string
     */
    abstract public function getForm();

    /**
     * Set the field options to be passed to the form
     *
     * @param FieldDefinitionInterface $fieldDefinition
     * @param string                   $field
     * @param array                    $fieldOptions
     * @param string                   $widget
     * @param array                    $widgetOptions
     *
     * @return array
     * @internal param array $widgetOptions
     */
    protected function getFormOptions(
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        return [
            'field'          => $fieldDefinition,
            'field_options'  => $fieldOptions,
            'widget_options' => $widgetOptions,
            'data_class'     => $fieldDefinition->getEntityClass(),
        ];
    }

    /**
     * @param FormMapper               $formMapper
     * @param FieldDefinitionInterface $fieldDefinition
     * @param string                   $field
     * @param array                    $fieldOptions
     * @param array                    $widget
     * @param array                    $widgetOptions
     *
     */
    public function configureForm(
        FormMapper $formMapper,
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        $isMultiple = $fieldOptions['limit'] > 1 || $fieldOptions['limit'] < 0;

        if ($isMultiple) {
            $formMapper->add(
                $field,
                'field_collection',
                [
                    'type'          => $this->getForm(),
                    'options'       => [
                                           'label'    => false,
                                           'required' => $fieldOptions['required'],
                                       ] + $this->getFormOptions(
                            $fieldDefinition,
                            $field,
                            $fieldOptions,
                            $widget,
                            $widgetOptions
                        ),
                    'field'         => $fieldDefinition,
                    'field_options' => $fieldOptions,
                    'widget'        => $widget,
                    'allow_add'     => $isMultiple,
                    'allow_delete'  => $isMultiple,
                    'by_reference'  => false,
                ]
            );
        } else {
            $formMapper->add(
                $field,
                $this->getForm(),
                [
                    'label'    => null,
                    'required' => $fieldOptions['required'],
                ] + $this->getFormOptions($fieldDefinition, $field, $fieldOptions, $widget, $widgetOptions)
            );
        }
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
