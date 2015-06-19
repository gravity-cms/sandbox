<?php


namespace Gravity\CmsBundle\Field\Twig;

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
     * @param FieldManager $fieldManager
     */
    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
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
            $fieldWidgetAssetLibs = $fieldWidget->getAssetLibraries([]);
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
    public function getName()
    {
        return 'gravity_cms_field';
    }
}
