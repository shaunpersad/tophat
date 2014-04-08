
var cache = new Object();

var $id_destination = false;

var alert_interval = 500;

function showAlerts() {

    var alerts_height = $('.alerts').show().height();

    var num_alerts = $('.alerts-container .alert').length;

    if (num_alerts){

        $('.alerts').hide().show( 'blind', {direction: 'up'}, 500, function() {

            setTimeout(function() {

                removeAlert($('.alerts-container .alert').last());

                $('.alerts').delay(alert_interval).hide('blind', {direction: 'up'}, alert_interval * num_alerts, function() {

                    $(this).find('.alerts-container').remove();

                });

            }, (alert_interval * num_alerts) + 2000);

        });


    }

}

function removeAlertContainer() {

    $('.alerts').hide('blind', {direction: 'up'}, 'slow', function() {

        $(this).find('.alerts-container').remove();
    });
}

function removeAlert($alert) {

    var index = $('.alerts-container .alert').index($alert);

    $alert.fadeOut(alert_interval, function() {

        /*
        if (index == 0) {

            removeAlertContainer();

        }
        */
    });

    if (index) {

        setTimeout(function() {

            removeAlert($alert.prev());

        }, alert_interval);
    }



}

function checkForFancyTextToggles() {


    $('.toggle-fancy-text').each(function() {

        if ($(this).is(':checked')) {

            $(this).parent('label').siblings('textarea').ckeditor();
        }

    });
}

function convertMetaFields() {


    $('.meta-panel .meta-type').each(function() {

        var $panel = $(this).closest('.meta-panel');
        //var title = $panel.find('.meta-title').val();
        var type = $(this).val();
       // var value = $panel.find('.meta-value').val();
        var uniqid = $panel.attr('id');

        if (type == 'fancy-text') {

            $('#meta-value-'+uniqid).ckeditor();

        } else if (type == 'date') {

            $('#meta-value-'+uniqid).datepicker();

        } else if (type == 'date-time') {

            $('#meta-value-'+uniqid).datetimepicker();

        }

    });

}

function getCacheStats() {


    $.get('/admin/dashboard/cache-stats', function(stats) {

        if (stats) {

            var mega = 1000000;

            Morris.Donut({
                element: 'cache-hits-misses',
                data: [
                    {label: "Hits", value: stats.hits},
                    {label: "Misses", value: stats.misses}
                ]
            });

            Morris.Donut({
                element: 'cache-memory-usage',
                data: [
                    {label: "Used", value: (stats.memory_usage / mega).toFixed(2)},
                    {label: "Available", value: (stats.memory_available / mega).toFixed(2)}
                ]
            });
        } else {
            $('#cache-hits-misses, #cache-memory-usage').html('Cache disabled.');
        }

    });

}


$(document).ready(function() {

    showAlerts();
    checkForFancyTextToggles();
    convertMetaFields();


    if ($('#cache-hits-misses, #cache-memory-usage').length) {

        getCacheStats();
    }


    if ($('#post-tags').length) {

        var tags = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/admin/tags',
            remote: '/admin/tags?query=%QUERY'
        });

        tags.initialize();

        $('#post-tags').tokenfield({
            typeahead: {
                name: 'tags',
                displayKey: 'title',
                source: tags.ttAdapter(),
                createTokensOnBlur: true
            }
        });
    }


    $('#post-date-published').datetimepicker();

    $( "#accordion" ).sortable();

    $('#section-posts').sortable();

    $(document)
        .on('click', '.open-popup', function(e) {

            e.preventDefault();

            var $destination = $(this).siblings('.destination');

            if ($destination.length) {

                $id_destination = $destination;
            }

            var fancybox_options = {
                type: 'ajax',
                href: $(this).attr('href'),
                wrapCSS: 'admin-upload-popup',
                minWidth: 800,
                padding: 0,
                margin: 0
            };

            $.fancybox.open(fancybox_options);
        })

        .on('click', '.view-image', function(e) {

            e.preventDefault();

            var fancybox_options = {
                type: 'image',
                href: $(this).attr('href')
            };

            $.fancybox.open(fancybox_options);
        })

        .on('submit', '#source-computer form, #source-url form, #source-embed-code form', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {

                $(this).ajaxSubmit({

                    success: function(response, statusText, xhr, $form) {


                        if (response) {

                            if ($(response).is('#image-editor')) {

                                $('#image-editor').html($(response).html());

                                if ($('#image-editor .image-to-edit img').length) {

                                    $('#image-editor .image-to-edit img', {
                                        load: function() {

                                            var select_options =  {
                                                disable: true,
                                                handles: true
                                            };

                                            $(this).imgAreaSelect(select_options);
                                        }
                                    });
                                }

                            } else if ($(response).is('#video-editor')) {

                                $('#video-editor').html($(response).html());

                            } else if ($(response).is('#audio-editor')) {

                                $('#audio-editor').html($(response).html());

                            } else if ($(response).is('#document-editor')) {

                                    $('#document-editor').html($(response).html());

                            }

                            $.fancybox.reposition();

                        }
                    }
                });

            }

        })

        .on('change', '#image-editor .radio-container input[type="radio"]', function() {


            if ($('#image-editor .image-to-edit img').length) {


                var $radio = $(this);

                var ratio = $radio.val().replace('ratio-', '');

                var select_options = new Object();

                if (ratio == 'original') {

                    select_options['disable'] = true;
                    select_options['hide'] = true;

                } else {

                    select_options['aspectRatio'] = ratio;
                    select_options['disable'] = false;
                    select_options['onSelectEnd'] = function (img, selection) {

                        $radio.attr('data-x1', selection.x1);
                        $radio.attr('data-x2', selection.x2);
                        $radio.attr('data-y1', selection.y1);
                        $radio.attr('data-y2', selection.y2);
                        $radio.attr('data-width', selection.width);
                        $radio.attr('data-height', selection.height);
                    };

                    if ($radio.attr('data-x1') && $radio.attr('data-x1').length) {

                        select_options['x1'] = $radio.attr('data-x1');
                        select_options['x2'] = $radio.attr('data-x2');
                        select_options['y1'] = $radio.attr('data-y1');
                        select_options['y2'] = $radio.attr('data-y2');

                    } else {

                    }

                }

                var $ias = $('#image-editor .image-to-edit img').imgAreaSelect({ instance: true });
                $ias.cancelSelection();
                $ias.setOptions(select_options);
                $ias.update();

                $('#image-editor .radio-container').find('label.active').removeClass('active');
                $radio.siblings('label').addClass('active');

            }

        })

        .on('submit', '#image-editor #save-image-data', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {



                var image_data = new Object();

                image_data.id = $(this).find('input[name="id"]').val();
                image_data.title = $(this).find('input[name="title"]').val();
                image_data.description = $(this).find('textarea[name="description"]').val();

                image_data.path = $('#image-editor .image-to-edit img').attr('data-path');

                image_data.ratios = new Array();

                $('#image-editor .radio-container input[name="ratio"]').each(function() {

                    var $radio = $(this);

                    if ($radio.attr('data-x1') && $radio.attr('data-x1').length && parseInt($radio.attr('data-width')) && parseInt($radio.attr('data-height'))) {

                        var data = new Object();

                        var ratio = $radio.val().replace('ratio-', '');
                        var ratio_array = ratio.split(':');

                        data.breadth = ratio_array[0];
                        data.length = ratio_array[1];
                        data.x1 = $radio.attr('data-x1');
                        data.x2 = $radio.attr('data-x2');
                        data.y1 = $radio.attr('data-y1');
                        data.y2 = $radio.attr('data-y2');
                        data.width = $radio.attr('data-width');
                        data.height = $radio.attr('data-height');


                        image_data.ratios.push(data);
                    }

                });

                $.post('/admin/image-editor/save', {image_data: JSON.stringify(image_data)}, function(image_data) {

                    if (image_data) {

                        if ($id_destination) {

                            $id_destination.val(image_data.id);

                            var $preview_button = $id_destination.siblings('.preview');
                            var $edit_button = $id_destination.siblings('.media-editor');

                            $id_destination.siblings('.can-hide').removeClass('hidden');

                            if ($preview_button.length) {

                                $preview_button.attr('href', '/admin/media/'+image_data.id+'/preview');
                            }
                            if ($edit_button.length) {

                                $edit_button.attr('href', '/admin/image-editor/'+image_data.id+'/edit');
                            }


                            if ($id_destination.attr('id') == 'post-image-id') {

                                $id_destination
                                    .closest('.formspacer')
                                    .siblings('.post-image-container')
                                    .find('.post-image')
                                    .html('<a class="view-image" href="'+image_data.url+'"><img src="'+image_data.url+'" class="img-thumbnail" /></a>');

                            }
                        }


                        var $ias = $('#image-editor .image-to-edit img').imgAreaSelect({ instance: true });
                        $ias.cancelSelection();

                        $.fancybox.close();

                    } else {

                        alert('An error occurred');

                    }


                });


            }


        })

        .on('submit', '#video-editor #save-video-data, #audio-editor #save-audio-data, #document-editor #save-document-data', function(e) {

            e.preventDefault();

            var media_type = $(this).attr('id').replace('-data', '').replace('save-', '');


            $(this).validate();

            if ($(this).valid()) {

                $(this).ajaxSubmit({

                    success: function(data, statusText, xhr, $form) {

                        if (data) {

                            if ($id_destination) {

                                $id_destination.val(data.id);

                                var $preview_button = $id_destination.siblings('.preview');
                                var $edit_button = $id_destination.siblings('.media-editor');

                                $id_destination.siblings('.can-hide').removeClass('hidden');

                                if ($preview_button.length) {

                                    $preview_button.attr('href', '/admin/media/'+data.id+'/preview');
                                }
                                if ($edit_button.length) {

                                    $edit_button.attr('href', '/admin/'+media_type+'-editor/'+data.id+'/edit');
                                }

                            }

                            $.fancybox.close();

                        } else {

                            alert('An error occurred');

                        }
                    }
                });

            }

        })

        .on('click', '#media-selector .pagination a, #media-selector th a, #media-selector form a', function(e) {

            e.preventDefault();

            var url = $(this).attr('href');

            $('#media-selector .panel-body').load(url+' .table-responsive');

        })

        .on('submit', '#media-selector form', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {

                $(this).ajaxSubmit({

                    success: function(data, statusText, xhr, $form) {

                        var $table = $(data).find('.table-responsive');

                        if ($table.length) {

                            $('#media-selector .panel-body').html($table);

                        }

                    }
                });

            }

        })

        .on('click', '.remove-destination', function(e) {

            var $local_destination = $(this).siblings('.destination');

            if ($local_destination.length) {

                $local_destination.val('');
            }

            if ($id_destination) {
                $id_destination.siblings('.can-hide').addClass('hidden');
            }


            if ($local_destination.attr('id') == 'post-image-id') {

                $local_destination
                    .closest('.formspacer')
                    .siblings('.post-image-container')
                    .find('.post-image')
                    .html('<img style="width: 300px; height: 300px" src="/images/placeholder.jpg" class="post-thumbnail" />');

            }
            $id_destination = false;
        })
        .on('change', '.toggle-fancy-text', function() {

            if ($(this).is(':checked')) {

                $(this).parent('label').siblings('textarea').ckeditor();

            } else {

                var editor = $(this).parent('label').siblings('textarea').ckeditor().editor;
                if (editor) {
                    editor.destroy();
                }
            }



        })
        .on('keypress', 'input[type="text"]', function(e) {

            if (e.which == 13) {

                e.preventDefault();
                return false;
            }
        })
        .on('change', '.categories-container input[type="checkbox"]', function() {

           $(this).closest('label').toggleClass('checked');
        })

        .on('change','.meta-panel .meta-type', function() {

            var $panel = $(this).closest('.meta-panel');
            var title = $panel.find('.meta-title').val();
            var type = $(this).val();
            var value = $panel.find('.meta-value').val();
            var uniqid = $panel.attr('id');

            var data = {
                title: title,
                type: type,
                value: value,
                uniqid: uniqid
            };

            $.post('/admin/posts/meta-field', data, function(response) {

                if ($(response).is('.meta-panel')) {

                    $panel.find('.meta-values').html($(response).find('.meta-values').html());

                    if (type == 'fancy-text') {

                        $('#meta-value-'+uniqid).ckeditor();

                    } else if (type == 'date') {

                        $('#meta-value-'+uniqid).datepicker();

                    } else if (type == 'date-time') {

                        $('#meta-value-'+uniqid).datetimepicker();

                    }
                }

            });


        })

        .on('click', '.add-another-meta-field', function() {

            $.get('/admin/posts/meta-field',function(response) {

                $('#accordion').append(response);
            });
        })
        .on('click', '.remove-meta', function() {

            $(this).closest('.meta-panel').remove();

        })

        .on('submit', '#post-form, #category-form', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {

                this.submit();
            }


        })
        .on('click', '.preview', function(e) {
            e.preventDefault();

            var $this = $(this);
            var url = $this.attr('href');

            if ($this.attr('data-popover-url') != url) {

                $.get(url, function(response) {
                    if (response) {

                        $this.popover('destroy');
                        $this.popover({
                            html: true,
                            content: response,
                            container: 'body',
                            placement: 'top'
                        }).attr('data-popover-url', url);

                        $this.popover('show');
                    }
                });
            }

        })

        .on('click', '.use-post:not(.posts-for-sections .use-post)', function() {

            var post_id = $(this).attr('data-post-id');

            if ($id_destination) {

                $id_destination.val(post_id);

                var $preview_button = $id_destination.siblings('.preview');

                $id_destination.siblings('.can-hide').removeClass('hidden');

                if ($preview_button.length) {

                    $preview_button.attr('href', '/admin/posts/'+post_id+'/preview');
                }
            }

            $.fancybox.close();

        })

        .on('click', '.posts-for-sections .use-post', function() {

            var post_id = $(this).attr('data-post-id');

            $.get('/admin/sections/post?post_id='+post_id, function(response) {

                if ($(response).is('.section-post')) {

                    $('#section-posts').append(response);
                }

            });
        })


        .on('click', 'button[type="reset"]', function() {

            $(this).closest('form').find('input').val('');
        })


        .on('click', '.edit-category', function() {

            var category_id = $(this).attr('data-category-id');
            var category_title = $(this).parent().siblings('.category-title').text();
            var category_slug = $(this).parent().siblings('.category-slug').text();

            $('#category-form input[name="id"]').val(category_id);
            $('#category-form input[name="title"]').val(category_title);
            $('#category-form input[name="slug"]').val(category_slug);

        })

        .on('click', '.edit-section', function() {

            var section_id = $(this).attr('data-section-id');
            var section_title = $(this).parent().siblings('.section-title').text();
            var section_slug = $(this).parent().siblings('.section-slug').text();

            $('#section-form input[name="id"]').val(section_id);
            $('#section-form input[name="title"]').val(section_title);
            $('#section-form input[name="slug"]').val(section_slug);

        })

        .on('click', '#posts-list a, #categories-list a:not(.delete-category), #sections-list a:not(.curate-section)', function(e) {

            e.preventDefault();
            var url = $(this).attr('href');

            $.get(url, function (response) {

                var $table = false;

                if ($(response).is('.table-responsive')) {

                    $table = $(response);
                } else {

                    $table = $(response).find('.table-responsive');
                }

                if ($table && $table.length) {

                    $('.table-responsive').html($table.html());
                }

            })

        })

        .on('submit', '#posts-list form, #categories-list form, #sections-list form', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {

                $(this).ajaxSubmit({

                    success: function(response, statusText, xhr, $form) {

                        var $table = false;

                        if ($(response).is('.table-responsive')) {

                            $table = $(response);
                        } else {

                            $table = $(response).find('.table-responsive');
                        }
                        if ($table && $table.length) {

                            $('.table-responsive').html($table.html());
                        }

                    }
                });

            }

        })

        .on('submit', '#curated-posts-form', function(e) {

            e.preventDefault();

            $(this).validate();

            if ($(this).valid()) {

                $(this).ajaxSubmit({

                    success: function(response, statusText, xhr, $form) {

                        $('.alerts').html(response);

                        showAlerts();

                    }

                });
            }

        })
        .on('click', '.section-post .btn', function() {

            $(this).closest('.section-post').remove();
        })

        .on('click','.btn-toggle-dropdowns', function() {

            $(this).find('.fa').toggleClass('fa-caret-down fa-caret-up');
        })
    ;


});