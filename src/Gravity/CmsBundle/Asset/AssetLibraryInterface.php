<?php


namespace Gravity\CmsBundle\Asset;

/**
 * Class AssetLibraryInterface
 *
 * @package Gravity\CmsBundle\Asset
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
interface AssetLibraryInterface 
{
    /**
     * @return array
     */
    public function getJavascripts();

    /**
     * @return array
     */
    public function getStylesheets();
}
