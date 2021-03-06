$(document).ready(function() {
    var placeholderName = 'placeholdervalue';
    $('['+placeholderName+']').each(function() {
        tmp = $(this).attr(placeholderName);
        if ($(this).val() === '')
        {
            $(this).val(tmp);
            $(this).addClass(placeholderName);
        }
        ;

        $(this).focus(function() {
            tmp = $(this).attr(placeholderName);
            if ($(this).val() === tmp)
            {
                $(this).removeClass(placeholderName);
                $(this).val('');
            }
        });
        $(this).blur(function() {
            tmp = $(this).attr(placeholderName);
            if ($(this).val() === '')
            {
                $(this).addClass(placeholderName);
                $(this).val(tmp);
            }
        });
        
        // Avoid form send placeholder value
        var inputHolder = $(this);
        $(this).closest('form').submit(function(){
           if(inputHolder.val() === inputHolder.attr(placeholderName)){
               inputHolder.val('');
           } 
        });
    });
})
