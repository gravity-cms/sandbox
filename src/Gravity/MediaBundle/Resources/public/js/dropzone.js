(function () {

    //Main module definition.
    define(
        ['jquery', 'jqueryui', rbundle('gravitymedia/vendor/dropzone/dist/min/dropzone-amd-module.min')],
        function ($, ui, Dropzone) {

            var events = {
                UPLOAD: 'upload',
                ERROR: 'error'
            };

            var eventListeners = {};

            for (var i in events) {
                eventListeners[event[i]] = [];
            }

            // setup dropzone
            Dropzone.autoDiscover = false;

            return {

                events: events,

                addListener: function (event, callback) {
                    eventListeners[event] = eventListeners[event] || [];
                    eventListeners[event].push(callback);
                },

                load: function (name, req, onload, config) {
                    //req has the same API as require().
                    req([name], function (value) {
                        onload(value);
                    });
                },

                dropzone: function ($dropzone, options) {

                    // load defaults
                    options = $.extend(true, {
                        maxFiles: null,
                        url: $dropzone.data('url'),
                        template: $dropzone.data('prototype'),
                        count: $dropzone.data('count')
                    }, options);

                    var dz = new Dropzone($dropzone[0], {
                        url: options.url,
                        paramName: 'binaryContent',
                        maxFiles: options.maxFiles,
                        acceptedFiles: 'image/*',
                        thumbnailWidth: null,
                        thumbnailHeight: null,
                        addRemoveLinks: true,

                        init: function () {
                            this.on("success", function (file, response) {
                                for (var i in eventListeners.upload) {
                                    eventListeners.upload[i].call(this, file, response);
                                }
                            });
                            this.on("error", function (file, response) {
                                this.removeFile(file);
                                alert("Cannot add file: " + response);
                            });
                        },
                        previewTemplate: options.template
                    });

                    dz.on('sending', function(file, xhr, formData){
                        formData.append('enabled', 1);
                        formData.append('name', file.name);
                        formData.append('context', 'default');
                    });

                    // dropzone doesn't bind the delete buttons if they were present before init (e.g. on edit pages)
                    $dropzone.find('.file-remove').on('click', function () {
                        $(this).closest('.file-tile').remove();
                    });

                    // set up the sortable content
                    $dropzone.sortable({
                        items: '> .file-tile',
                        create: function (event, ui) {
                        },
                        start: function (e, ui) {

                        },
                        stop: function (e, ui) {

                        }
                    });

                    return dz;
                }
            }
        });

})();
