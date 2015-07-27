<?php

namespace Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete\Asset;

use Gravity\CmsBundle\Asset\AbstractAssetLibrary;

/**
 * Class AutoCompleteWidgetAssetLibrary
 *
 * @package Gravity\CmsBundle\Field\Type\Reference\Widget\AutoComplete\Asset
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteWidgetAssetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            '/bundles/gravitycms/js/field/autocomplete.js'
        ];
    }
}
