'use strict';

var GRAVITYCMS = GRAVITYCMS || (function ($, sonata) {

        var $form,
            widgets = {};


        $(document).ready(function () {

            $form = $('.sonata-ba-form > form');

            //sonata.setup_collection_buttons('.field-group');

            //var $fieldGroups = $('.field-group');
            //$fieldGroups.each(function () {
            //    var $fieldGroup = $(this);
            //    var $fieldGroupList = $fieldGroup.find('.field-group-list');
            //    var $addButton = $fieldGroup.find('.form-add-widget');
            //    var widgetLimit = parseInt($addButton.data('limit'));
            //    var widgetType = $addButton.data('widget-type');
            //
            //    var getWidgetCount = function(){
            //        return $fieldGroupList.children('li').length;
            //    };
            //    var refreshWidgetState = function(){
            //        var c = getWidgetCount();
            //        if(widgetLimit == -1) {
            //            $addButton.attr('disabled', false);
            //        } else {
            //            if(c >= widgetLimit) {
            //                $addButton.attr('disabled', true);
            //            } else {
            //                $addButton.attr('disabled', false);
            //            }
            //        }
            //
            //
            //        return c;
            //    };
            //    $addButton.on('click', function () {
            //        if(widgetLimit !== -1 && refreshWidgetState() >= widgetLimit){
            //            return false;
            //        }
            //        var data = $addButton.data('prototype').replace(/__name__/g, getWidgetCount());
            //        var $newElement = $(data);
            //        $fieldGroupList.append($newElement);
            //        $fieldGroupList.sortable('refresh');
            //        if(widgetType) {
            //            nodeForm.bindWidget(widgetType, $newElement);
            //        }
            //        refreshWidgetState();
            //    });
            //    $fieldGroup.on('click', '.form-delete-widget', function(){
            //        var $btn = $(this);
            //        var $widget = $btn.closest('li.field-group-item ');
            //
            //        if(refreshWidgetState() <= 0){
            //            return false
            //        }
            //        $widget.remove();
            //        refreshWidgetState()
            //    });
            //    if (widgetLimit !== 1) {
            //        $fieldGroupList.sortable({
            //            axis: "y",
            //            containment: "parent",
            //            handle: '.field-sort-icon'
            //        });
            //        //$fieldGroupList.disableSelection();
            //    }
            //    refreshWidgetState();
            //});

            // register the widgets
            for(var i in widgets){
                widgets[i]($form);
            }
        });


        return {

            registerWidget: function (name, callback) {
                widgets[name] = callback;
                if($form){
                    callback($form);
                }
            },
            bindWidget: function (name, $widget) {
                var callback = widgets[name];
                if(callback) {
                    callback($widget);
                }
            }
        }
})(jQuery, Admin);
