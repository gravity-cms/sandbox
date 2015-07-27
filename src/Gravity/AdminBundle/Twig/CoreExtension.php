<?php

namespace Gravity\AdminBundle\Twig;

use Gravity\AdminBundle\Assetic\GravityAssetManager;
use Gravity\CmsBundle\Field\FieldManager;

class CoreExtension extends \Twig_Extension
{
    /**
     * @var GravityAssetManager
     */
    private $assetManager;

    /**
     * @var FieldManager
     */
    private $fieldManager;

    /**
     * @param GravityAssetManager $assetManager
     * @param FieldManager        $fieldManager
     */
    function __construct(GravityAssetManager $assetManager, FieldManager $fieldManager)
    {
        $this->assetManager = $assetManager;
        $this->fieldManager = $fieldManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('require_asset', [$this, 'requireAsset']),
            new \Twig_SimpleFunction('require_field_assets', [$this, 'requireFieldAssets']),
        ];
    }

    /**
     * @param $asset
     *
     * @return mixed
     */
    public function requireAsset($asset)
    {
        if (strpos($asset, '@') === 0) {
            $asset = $this->assetManager->getAsset($asset);
        }

        if (strpos($asset, ' / ') === 0) {
            $asset = substr($asset, 1);
        }

        return str_replace(' . js', '', $asset);
    }

    public function requireFieldAssets()
    {
        $assets = [];
        foreach($this->fieldManager->getFieldWidgetDefinitions() as $definition){
            foreach($definition->getAssetLibraries() as $library){
                $assets = array_merge($assets, $library->getJavascripts());
            }
        }

        return $assets;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'gravity_theme';
    }

} 
