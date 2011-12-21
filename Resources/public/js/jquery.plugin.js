/**
 * @author David Badura <badura@simplethings.de>
 */
(function($, jQuery) {
    jQuery.fn.simpleThingsFormExtraValidation = function (options) {
        options = jQuery.extend({}, jQuery.fn.simpleThingsFormExtraValidation.defaults, options);
        
        return $(this).each(function() {

            var objectName = $(this).data('simplethings-validation-class');
            
            $(this).find('input').each(function() {
                
                var $this = $(this);
              
                var name = $this.attr('name');
                name = name.substr(name.indexOf("[") + 1, name.indexOf("]") - name.indexOf("[") - 1);
                    
                $this.change(function() {

                    if(options.validator.isValid($this.val(), options.constraints[objectName][name])) {
                       options.onSuccess($this);
                    } else {
                       options.onError($this, options.validator.violations);
                    }

                });                    
                
            });
            
            
           
            
        });
    };
    
    jQuery.fn.simpleThingsFormExtraValidation.defaults = {
        validator: null,
        constraints: null,
        onSuccess: function(object) {},
        onError: function(object, violations) {}
    };
    
})(jQuery, jQuery);
