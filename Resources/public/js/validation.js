/**
 * @author David Badura <badura@simplethings.de>
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


var simpleThingsFormExtraValidationContraints = {
    max: function (value, constraint, validator) {
        if (isNaN(value)) {
            validator.addViolation(constraint.invalidMessage, value);
            return false;
        }
        
        if (value > constraint.limit) {
            validator.addViolation(constraint.message, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        return true;
    },
    min: function (value, constraint, validator) {
        if (isNaN(value)) {
            validator.addViolation(constraint.invalidMessage, value);
            return false;
        }
        
        if (value < constraint.limit) {
            validator.addViolation(constraint.message, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        return true;
    },
    blank: function (value, constraint, validator) {
        if ('' != value && null != value) {
            validator.addViolation(constraint.message, value);
            return false;
        }

        return true;        
    },
    email: function (value, constraint, validator) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (!reg.test(value)) {
            validator.addViolation(constraint.message, value);
            return false;
        }
        
        return true;
    },
    ip: function (value, constraint, validator) {
        var reg = /(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/;
        if(!reg.test(value)) {
            validator.addViolation(constraint.message, value);
            return false;
        }
        
        return true;
    },
    maxLength: function (value, constraint, validator) {
        if (null == value || '' == value) {
            return true;
        }        
        
        if(value.length > constraint.limit) {
            validator.addViolation(constraint.message, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        return true;
    },
    minLength: function (value, constraint, validator) {
        if (null == value || '' == value) {
            return true;
        }        
        
        if(value.length < constraint.limit) {
            validator.addViolation(constraint.message, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        return true;
    },
    notBlank: function (value, constraint, validator) {
        if ('' == value || null == value) {
            validator.addViolation(constraint.message, value);
            return false;
        }

        return true;          
    },
    regex: function (value, constraint, validator) {
        if (null == value || '' == value) {
            return true;
        }
        
        var reg = new RegExp(constraint.pattern);
        if(!reg.test(value)) {
            validator.addViolation(constraint.message, value);
            return false;
        }

        return true;     
    },
    size: function (value, constraint, validator) {
        if (isNaN(value)) {
            validator.addViolation(constraint.invalidMessage, value);
            return false;
        }        
        
        if( value < constraint.min) {
            validator.addViolation(constraint.minMessage, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        if( value > constraint.max) {
            validator.addViolation(constraint.maxMessage, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        return true;
    },
    sizeLength: function (value, constraint, validator) {
        if( value.length < constraint.min) {
            validator.addViolation(constraint.minMessage, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        if( value.length > constraint.max) {
            validator.addViolation(constraint.maxMessage, value, {'{{ limit }}': constraint.limit});
            return false;
        }
        
        return true;
    },
    time: function (value, constraint, validator) {
        var reg = /^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
        if(!reg.test(value)) {
            validator.addViolation(constraint.message, value);
            return false;
        }
        
        return true;
    },
    url: function (value, constraint, validator) {
        var reg = /(?:https?:\/\/(?:(?:(?:(?:(?:[a-zA-Z\d](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?)\.)*(?:[a-zA-Z](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?))|(?:(?:\d+)(?:\.(?:\d+)){3}))(?::(?:\d+))?)(?:\/(?:(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*)(?:\/(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))*)(?:\?(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))?)?)/;
        if(!reg.test(value)) {
            validator.addViolation(constraint.message, value);
            return false;
        }
        
        return true;
    },
    type: function (value, constraint, validator) {
        switch(constraint) {
            case 'numeric':
                if(isNaN(value)) {
                    validator.addViolation(constraint.message, value);
                    return false;
                }
                break;
            case 'string':
                if(typeof(value) != 'string') {
                    validator.addViolation(constraint.message, value);
                    return false;
                }
                break;
        }
        
        return true;
    },
    'true': function (value, constraint, validator) {
        if(!value) {
            validator.addViolation(constraint.message, value);
            return false;
        }
        
        return true;
    },    
    'false': function (value, constraint, validator) {
        if (null == value) {
            return true;
        }

        if (false == value || 0 == value) {
            return true;
        }
        
        validator.addViolation(constraint.message, value);
        return false;
    }
};