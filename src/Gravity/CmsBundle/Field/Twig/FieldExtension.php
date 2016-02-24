<?php


namespace Gravity\CmsBundle\Field\Twig;

use Gravity\CmsBundle\Entity\FieldableEntity;
use Gravity\CmsBundle\Field\FieldManager;

/**
 * Class FieldExtension
 *
 * @package Gravity\CmsBundle\Field\Twig
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldExtension extends \Twig_Extension
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * FieldExtension constructor.
     *
     * @param FieldManager $fieldManager
     */
    public function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_cms_field';
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        $fieldWidgets = $this->fieldManager->getFieldWidgetDefinitions();

        $javascripts = [];
        $stylesheets = [];
        foreach ($fieldWidgets as $fieldWidget) {
            $fieldWidgetAssetLibs = $fieldWidget->getAssetLibraries();
            foreach ($fieldWidgetAssetLibs as $fieldWidgetAssetLib) {
                $javascripts = array_merge($javascripts, $fieldWidgetAssetLib->getJavascripts());
                $stylesheets = array_merge($stylesheets, $fieldWidgetAssetLib->getStylesheets());
            }
        }

        return [
            'field_assets_js'  => $javascripts,
            'field_assets_css' => $stylesheets,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_field_display', [$this, 'renderFieldDisplay'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @param FieldableEntity   $entity
     * @param string            $field
     *
     * @return string
     * @internal param \Twig_Environment $environment
     */
    public function renderFieldDisplay(\Twig_Environment $environment, FieldableEntity $entity, $field)
    {
        $fieldMapping  = $this->fieldManager->getEntityFieldMapping(get_class($entity));
        $fieldSettings = $fieldMapping[$field];

        $html = '';

        if ($fieldSettings['display']['type']) {
            $display     = $this->fieldManager->getFieldDisplayDefinition($fieldSettings['display']['type']);
            $fieldEntity = call_user_func([$entity, 'get' . $field]);

            $templateOptions = [
                'entity'         => $fieldEntity,
                'field_settings' => $fieldSettings,
                'field_name'     => $field,
                'label'          => is_string($fieldSettings['display']['label']) ?: ($fieldSettings['display']['label']) ? $field : false,
                'label_inline'   => $fieldSettings['display']['label_inline'],
            ];

            if ($fieldSettings['options']['limit'] > 1) {
                $subHtml = '';

                $subTemplateOptions = $templateOptions;
                $subTemplateOptions['label'] = false;
                foreach ($fieldEntity as $fieldEntityItem) {
                    $subHtml .= $environment->render(
                        $display->getTemplate(),
                        $subTemplateOptions +
                        $display->getTemplateOptions($fieldEntityItem, $fieldSettings['display']['options'])
                    );
                }

                $templateOptions['rows'] = $subHtml;
                $html = $environment->render(
                    $display->getListTemplate(),
                    $templateOptions + $display->getListTemplateOptions($fieldEntity, $fieldSettings['display']['options'])
                );
            } else {
                $html = $environment->render(
                    $display->getTemplate(),
                    $templateOptions + $display->getTemplateOptions($fieldEntity, $fieldSettings['display']['options'])
                );
            }
        }

        return $html;
    }
}
