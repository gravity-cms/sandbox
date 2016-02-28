<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

use Gravity\CmsBundle\Asset\AbstractAssetLibrary;

/**
 * Class GravityMediaWidgetAssetLibrary
 *
 * @package Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityMediaWidgetAssetLibrary extends AbstractAssetLibrary
{
    /**
     * @inheritDoc
     */
    public function getJavascripts()
    {
        return [
            'bundles/gravitymedia/vendor/dropzone/dist/min/dropzone.min.js',
            'bundles/gravitymedia/js/dropzone.js',
            'bundles/gravitymedia/js/field/gravity-media.js',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getStylesheets()
    {
        return [
            '@GravityMediaBundle/Resources/assets/sass/gravity-media-field.scss',
        ];
    }

}
