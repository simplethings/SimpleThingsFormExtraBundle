/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var simpleThingsFormExtraValidator = {
    
    violations: [],
    
    isValid: function(value, constraints) { 
        this.violations = [];
        for(var constraint in constraints){
            if(typeof simpleThingsFormExtraValidationContraints[constraint] == 'function') {
                var re = simpleThingsFormExtraValidationContraints[constraint](value, constraints[constraint], this);
                if(!re) {
                    return false;
                }
            }
        } 
        return true;
    },
    
    addViolation: function(message, value, constraint) {
        this.violations.push(new SimpleThingsFormExtraViolation(message, value, constraint));
    }
    
};

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function SimpleThingsFormExtraViolation (message, value, params) {
    
    this.message = message;
    this.value = value;
    this.params = params;
    
    this.getMessage = function() {
        var message = this.message;
        for(var key in this.params) {
            message = message.replace(key, this.params[key]);
        }
        return message;
    }
    
}

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var simpleThingsFormExtraValidationContraints = {
    max: function (value, constraint) {
        
        if (!isNaN(value)) {
            return false;
        }
        
        if (value > constraint.limit) {
            return false;
        }
        
        return true;
    },
    min: function (value, constraint) {
        if (!isNaN(value)) {
            return false;
        }
        
        if (value < constraint.limit) {
            return false;
        }
        
        return true;
    },
    blank: function (value, constraint) {
        if ('' != value && null != value) {
            return false;
        }

        return true;        
    },
    email: function (value, constraint) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (!reg.test(value)) {
            return false;
        }
        
        return true;
    },
    falseValidator: function (value, constraint) {
        if (null == value) {
            return true;
        }

        if (false == value || 0 == value) {
            return true;
        }
        
        return false;
    },
    ip: function (value, constraint) {
        var reg = /(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/;
        if(!reg.test(value)) {
            return false;
        }
        
        return true;
    },
    maxLength: function (value, constraint) {
        if(value.length > constraint.limit) {
            return false;
        }
        return true;
    },
    minLength: function (value, constraint, validator) {
        if(value.length < constraint.limit) {
            validator.addMessage(constraint.message, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        return true;
    },
    notBlank: function (value, constraint) {
        if ('' == value || null == value) {
            return false;
        }

        return true;          
    },
    regex: function (value, constraint) {
        if (null == value || '' == value) {
            return true;
        }
        
        var reg = new RegExp(constraint.pattern);
        if(!reg.test(value)) {
            return false;
        }

        return true;     
    },
    size: function (value, constraint) {
        if( value < constraint.min) {
            return false;
        }
        
        if( value > constraint.max) {
            return false;
        }
        
        return true;
    },
    sizeLength: function (value, constraint) {
        if( value.length < constraint.min) {
            return false;
        }
        
        if( value.length > constraint.max) {
            return false;
        }
        
        return true;
    },
    time: function (value, constraint) {
        var reg = /^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
        if(!reg.test(value)) {
            return false;
        }
        
        return true;
    },
    trueValidation: function (value, constraint) {
        if(!value) {
            return false;
        }
        
        return true;
    },
    url: function (value, constraint) {
        var reg = /(?:https?:\/\/(?:(?:(?:(?:(?:[a-zA-Z\d](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?)\.)*(?:[a-zA-Z](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?))|(?:(?:\d+)(?:\.(?:\d+)){3}))(?::(?:\d+))?)(?:\/(?:(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*)(?:\/(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))*)(?:\?(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))?)?)/;
        if(!reg.test(value)) {
            return false;
        }
        
        return true;
    }
 
};