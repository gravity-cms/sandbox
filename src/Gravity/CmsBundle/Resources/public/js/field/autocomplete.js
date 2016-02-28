'use strict';

(function (fields) {
    fields.registerWidget('autocomplete', function ($scope) {
        $(document).ready(function () {

            $scope.find('input.auto-complete-widget').each(function () {
                var $input = $(this),
                    isMultiple = this.dataset.multiple === "1" || this.dataset.multiple === 1,
                    allowNew = this.dataset.allowNew === "1" || this.dataset.allowNew === 1;
                $input.wrap('<div class="select2-primary"></div>').select2({
                    placeholder: "Select tags",
                    multiple: isMultiple,
                    tags: allowNew,
                    maximumSelectionSize: this.dataset.limit,
                    initSelection: function (element, callback) {
                        var items = JSON.parse(element.val());
                        var data = [];
                        var ids = [];
                        for (var i in items) {
                            ids.push(i);
                            data.push({id: i, text: items[i]});
                        }
                        element.val(ids.join(','));
                        if (isMultiple) {
                            callback(data);
                        } else {
                            if ("undefined" != typeof data[0]) {
                                callback(data[0]);
                            }
                        }
                    },
                    ajax: {
                        url: $input.data('url'),
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params // search term
                            };
                        },
                        cache: true,
                        results: function (data) {
                            // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data
                            return {
                                results: data.items
                            };
                        }
                    },
                    minimumInputLength: 2
                });
            });
        });
    });
})(GRAVITY.fields);
