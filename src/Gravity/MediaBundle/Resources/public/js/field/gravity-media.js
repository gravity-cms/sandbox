'use strict';

(function (fields, Dz) {
    fields.registerWidget('gravity.media', function ($scope) {
        $scope.find('.gravity-media-widget').each(function () {
            var $widgetContainer = $(this);
            var $dropzone = $widgetContainer.find('.dropzone-box');
            var $mediaDetails = $widgetContainer.find('.media-details');
            var $fieldContainer = $widgetContainer.find('.media-form-fields');
            var $mediaIdField = $fieldContainer.find('input[name$="[media]"]');
            var $mediaImage = $widgetContainer.find('img.media-object');
            var $mediaName = $widgetContainer.find('.media-name');
            var dropzone = Dz.dropzone($dropzone, {});
            var imagePreviewType = $dropzone.data('image-preview');

            if (!$mediaIdField.val()) {
                $mediaDetails.hide();
            } else {
                $dropzone.hide();
            }

            $widgetContainer.on('click', '.media-remove', function () {
                $dropzone.show();
            });

            dropzone.on('success', function (file, response) {
                console.log(response);
                if (response.id) {
                    $mediaIdField.val(response.id);
                    $mediaImage.attr({
                        src: response.styles[imagePreviewType],
                        height: null,
                        width: null
                    });
                    $mediaName.text(response.name);

                    $mediaDetails.show();
                    $dropzone.hide();
                }

                dropzone.removeFile(file);
            });
        });
    });
})(GRAVITY.fields, GRAVITY.dropzone);
