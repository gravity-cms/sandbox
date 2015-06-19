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
            'bundles/gravitycms/js/field/text/text.js'
        ];
    }
}
