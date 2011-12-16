(function($, jQuery) {
    jQuery.fn.simplethingsFormextraValidation = function (options) {
        options = jQuery.extend({}, jQuery.fn.SimpleThingsFormExtraValidation.defaults, options);

        return $(this).each(function() {
            
            var self = $(this);
            
            self.change(function() {
                
                if(options.validator.isValid(self.val(), self.data('simplethings-validation-contraints'))) {
                    
                   self.removeClass('error');
                   self.addClass('success');
                   
                } else {
                    
                   self.removeClass('success');
                   self.addClass('error');

                }
                
            });
            
        });
    }
    jQuery.fn.SimpleThingsFormExtraValidation.defaults = {
        validator: simpleThingsFormExtraValidator
    }
})(jQuery, jQuery);