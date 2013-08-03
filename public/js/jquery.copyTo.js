(function($) {

    $.fn.copyTo = function(args) {

        $('.copyTo').click(function() {
            var from = $(this).attr('data-from');
            var to = $(this).attr('data-to');
            var fromVal = $(from).val();

            $(to).val(fromVal);
        });

    };

})(jQuery);