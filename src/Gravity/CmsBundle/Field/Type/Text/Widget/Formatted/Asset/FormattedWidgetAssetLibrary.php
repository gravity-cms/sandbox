<?php


namespace Gravity\CmsBundle\Field\Type\Text\Widget\Formatted\Asset;

use Gravity\CmsBundle\Asset\AbstractAssetLibrary;

/**
 * Class FormattedWidgetAssetLibrary
 *
 * @package Gravity\CmsBundle\Field\Type\Text\Widget\Formatted\Asset
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidgetAssetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            'bundles/ivoryckeditor/ckeditor.js',
            'bundles/sonataformatter/vendor/markitup-markitup/markitup/jquery.markitup.js',
            'bundles/sonataformatter/markitup/sets/html/set.js',
            'bundles/sonataformatter/markitup/sets/textile/set.js',
            'bundles/sonataformatter/markitup/sets/markdown/set.js',
            'bundles/gravitycms/js/field/text/text.js',
        ];
    }
}
