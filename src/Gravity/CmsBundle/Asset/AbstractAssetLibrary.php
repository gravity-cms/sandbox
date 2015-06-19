<?php


namespace Gravity\CmsBundle\Asset;

/**
 * Class AbstractAssetLibrary
 *
 * @package Gravity\CmsBundle\Asset
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class AbstractAssetLibrary implements AssetLibraryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getJavascripts()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getStylesheets()
    {
        return [];
    }
}
