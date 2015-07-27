<?php


namespace Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete\Asset\AutoCompleteWidgetAssetLibrary;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AutoCompleteWidget
 *
 * @package Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteWidget extends AbstractFieldWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'autocomplete';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Auto Complete Search';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Reference using Auto Complete Search';
    }

    /**
     * Get the form type for the widget
     *
     * @return AbstractType|string
     */
    public function getForm()
    {
        return new AutoCompleteWidgetForm();
    }

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
     */
    protected function getFormOptions(
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        return [
            'handler'         => $widgetOptions['handler'],
            'handler_options' => [
                'class'        => $fieldOptions['entity'],
                'page_size'    => 10,
                'page_offset'  => 0,
                'allow_new'    => $widgetOptions['allow_new']
//                'autocomplete_route' => $options['autocomplete_route'],
            ],
            'limit'           => $fieldOptions['limit'],
            'multiple'        => $fieldOptions['limit'] != 1,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureForm(
        FormMapper $formMapper,
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        $formMapper->add(
            $field,
            $this->getForm(),
            [
                'label'    => null,
                'required' => $fieldOptions['required'],
            ] + $this->getFormOptions($fieldDefinition, $field, $fieldOptions, $widget, $widgetOptions)
        );
    }


    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setRequired(
            [
                'handler'
            ]
        );
        $optionsResolver->setDefaults(
            [
                'allow_new'          => false,
                'handler_options'    => [],
                'autocomplete_route' => 'gravity_cms_autocomplete',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetLibraries()
    {
        return [
            new AutoCompleteWidgetAssetLibrary()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof ReferenceField;
    }
}
