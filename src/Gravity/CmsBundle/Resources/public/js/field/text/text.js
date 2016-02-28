'use strict';

(function (fields) {
    var isInstanceActive = function (instance) {
        return instance && instance.status !== "destroyed";
    };

    // TODO: allow adding of extra plugins
    CKEDITOR.plugins.addExternal('divarea', '/bundles/gravitycms/vendor/ckeditor-plugins/divarea/');
    CKEDITOR.plugins.addExternal('wordcount', '/bundles/gravitycms/vendor/ckeditor-plugins/wordcount/');

    fields.registerWidget('text', function ($scope) {

        $scope.find('.sonata-formatter-widget').each(function () {
            var $widget = $(this);
            var $inputBox = $widget.children('textarea');
            var $formatSelector = $widget.find('select');
            var ckConfig = $widget.data('config');
            var instance = false;

            $widget.parents("form").on('click', function (event) {
                if (isInstanceActive(instance)) {
                    instance.updateElement();
                }
            });

            $formatSelector.on('change', function (event) {
                var elms = $inputBox;
                elms.markItUpRemove();
                if (isInstanceActive(instance)) {
                    instance.destroy();
                }

                var val = jQuery(this).val();
                var appendClass = val;
                switch (val) {
                    case 'textile':
                        elms.markItUp(markitup_sonataTextileSettings);
                        break;
                    case 'markdown':
                        elms.markItUp(markitup_sonataMarkdownSettings);
                        break;
                    case 'bbcode':
                        elms.markItUp(markitup_sonataBBCodeSettings);
                        break;
                    case 'rawhtml':
                        elms.markItUp(markitup_sonataHtmlSettings);
                        appendClass = 'html';
                        break;
                    case 'richhtml':
                        instance = CKEDITOR.replace($inputBox.attr('id'), ckConfig);
                        break;
                }

                var parent = elms.parents('div.markItUp');

                if (parent) {
                    for (var name in ['textile', 'markdown', 'bbcode', 'rawhtml', 'richhtml', 'rawhtml']) {
                        parent.removeClass(name)
                    }

                    parent.addClass(appendClass);
                }

            });

            $formatSelector.trigger('change');
        });
    });
})(GRAVITY.fields);
