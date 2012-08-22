$(document).ready(function(){
    $('.form_url_maker').each(function(){
        var el = $(this);
        var action = el.attr('action');
        bts= el.find('input, button').filter(':submit');
        bts.click(function(){
            var values = el.serialize();
            var str = '/';
            params_a = values.split('&');
            for(i in params_a){
                v = params_a[i].split("=");
                str += v[0]+'/'+v[1]+'/';
            }
            document.location = action+str;
            return false;
        })
    });
    
    $('.ui-button').button();
    $('.ui-button-force-disabled').button("option", "disabled", true);
    $('.row_data').click(function(){
        $('.row_data').removeClass('row_data-hover');
        $(this).addClass('row_data-hover');
    })
    $('select').selectmenu();
    
    $('.ui-input-pass').hover(function(){
        $(this).addClass('ui-state-hover')
    },function(){
        $(this).removeClass('ui-state-hover')
    });
    $('.ui-input-pass').focus(function(){
        $(this).addClass('ui-state-focus')
        console.log('loadded')
    })
    
    $('.ui-input-pass').blur(function(){
        $(this).removeClass('ui-state-focus')
    })
    
    $('.ui-input-text').hover(function(){
        $(this).addClass('ui-state-hover')
    },function(){
        $(this).removeClass('ui-state-hover')
    });
                
    $('.ui-input-text').focus(function(){
        $(this).addClass('ui-state-focus')
    })
    $('.ui-input-text').blur(function(){
        $(this).removeClass('ui-state-focus')
    })
    
    $('.error-helper').prev().css('border','1px solid #CD0A0A')
    
    $('.ui-image-admin').each(function(){
        $(this).children('a').click(function(e){
            e.preventDefault();
            $('body').css('cursor','wait');
            $('#modal-content').html('<img src="'+$(this).attr('rel')+'" />').find('img').load(function(){
                
                //Get the window height and width
                var winH = $(window).height();
                var winW = $(window).width();
              
                $('#modal').css('top',winH/2-$(this).height()/2)
                $('#modal').css('left',winW/2-$(this).width()/2)
                $('#modal').reveal({
                    animation:'fade'
                });
                $('body').css('cursor','default');
            })
        })
    })
    
//    //file upload 
//    var uploader = new plupload.Uploader({
//        runtimes : 'gears,html5,flash,silverlight,browserplus',
//        browse_button : 'pickfiles',
//        container: 'container',
//        max_file_size : '10mb',
//        url : '',
//        flash_swf_url : '/PHPFarm/resources/lib/plupload/js/plupload.flash.swf',
//        filters : [
//        {
//            title : "Image files", 
//            extensions : "jpg,gif,png"
//        }
//        ]
//    });
//    
//    uploader.bind('Init', function(up, params) {
//        console.log('initing:')
//        console.log(up)
//        console.log(params)
//        $('#filelist').html( "<div>Current runtime: " + params.runtime + "</div>");
//    });
//
//    uploader.bind('FilesAdded', function(up, files) {
//        console.log('adding files')
//        console.log(up)
//        console.log(files)
//        for (var i in files) {
//            $('#filelist').append('<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>');
//        }
//    });
//
//    uploader.bind('UploadProgress', function(up, file) {
//        $('#'+file.id).find('b').get(0).append('<span>' + file.percent + "%</span>");
//    });
//
//    $('#uploadfiles').onclick = function() {
//        console.log('staring upload')
//        return false;
//    };
//    uploader.start();
    
// old
//    //file upload 
//    $('#container').pluploadQueue({
//	        // General settings
//	        runtimes : 'html5',
//	        url : 'upload.php',
//	        max_file_size : '10mb',
//	        chunk_size : '1mb',
//	        unique_names : true,
//	 
//	        // Resize images on clientside if we can
//	        resize : {width : 320, height : 240, quality : 90},
//	 
//	        // Specify what files to browse for
//	        filters : [
//	            {title : "Image files", extensions : "jpg,gif,png"},
//           
//        ]
//    })
})
