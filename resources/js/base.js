$(document).ready(function () {
    $('.form_url_maker').each(function () {
        var el = $(this);
        var action = el.attr('action');
        bts = el.find('input, button').filter(':submit');
        bts.click(function () {
            var values = el.serialize();
            var str = '/';
            params_a = values.split('&');
            for (i in params_a) {
                v = params_a[i].split("=");
                str += v[0] + '/' + v[1] + '/';
            }
            document.location = action + str;
            return false;
        })
    });

    // ui components
    $('select').selectmenu();


    $('.ui-button').button();
    $('.ui-button-force-disabled').button("option", "disabled", true);
    $('.row_data').click(function () {
        $('.row_data').removeClass('row_data-hover');
        $(this).addClass('row_data-hover');
    })
    $('.ui-input-pass').hover(function () {
        $(this).addClass('ui-state-hover')
    }, function () {
        $(this).removeClass('ui-state-hover')
    });
    $('.ui-input-pass').focus(function () {
        $(this).addClass('ui-state-focus')
        console.log('loadded')
    })

    $('.ui-input-pass').blur(function () {
        $(this).removeClass('ui-state-focus')
    })

    $('.ui-input-text').hover(function () {
        $(this).addClass('ui-state-hover')
    }, function () {
        $(this).removeClass('ui-state-hover')
    });

    $('.ui-input-text').focus(function () {
        $(this).addClass('ui-state-focus')
    })
    $('.ui-input-text').blur(function () {
        $(this).removeClass('ui-state-focus')
    })

    $('.error-helper').prev().css('border', '1px solid #CD0A0A')

    $('.ui-image-admin').each(function () {
        $(this).children('a').click(function (e) {
            e.preventDefault();
            $('body').css('cursor', 'wait');
            $('#modal-content').html('<img src="' + $(this).attr('rel') + '" />').find('img').load(function () {

                //Get the window height and width
                var winH = $(window).height();
                var winW = $(window).width();

                $('#modal').reveal({
                    animation:'fade'
                });
                $('#modal').css('top', winH / 2 - $(this).height() / 2)
                $('#modal').css('left', winW / 2 - $(this).width() / 2)

                $('body').css('cursor', 'default');
            })
        })
    })

    $('.multiple-upload-rows').each(function (i) {
        if (i % 2 == 0) {
            $(this).css({
                'background':'#ddd'
            });
        }
    })

    $('.dataTable').find('input').click(function () {

        var containSelected = false;
        $('.dataTable').find('input').each(function () {
            if ($(this).is(':checked')) {
                containSelected = true;
            }
        })
        var el = $('.dataTable').next();
        if (containSelected) {
            if (!el.is(':visible')) {
                el.fadeIn()
            }
        } else {

            if (el.is(':visible')) {
                el.fadeOut()
            }
        }
    })
    // textareas
    $('.ui-text-area').tinymce({
        // Location of TinyMCE script
        script_url:URL_HOME + 'resources/js/tiny_mce/tiny_mce.js',

        // General options
        theme:"advanced",
        plugins:"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

        // Theme options
        theme_advanced_buttons1:"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3:"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak",
        theme_advanced_toolbar_location:"top",
        theme_advanced_toolbar_align:"left",
        theme_advanced_statusbar_location:"bottom",
        theme_advanced_resizing:false,


        // Drop lists for link/image/media/template dialogs
        template_external_list_url:"lists/template_list.js",
        external_link_list_url:"lists/link_list.js",
        external_image_list_url:"lists/image_list.js",
        media_external_list_url:"lists/media_list.js"

    });

});