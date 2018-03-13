;(function(window, document) {

    var hasError = function(field) {
        // Fields we want to ignore
        if (field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') {
            return null; 
        }
        
        if (field.type === 'password' && field.id == 'input-password-confirm') {
            var passwordFields = field.form.querySelectorAll('input[type="password"');
            if ((passwordFields[0].value != passwordFields[1].value) && (passwordFields.length == 2)) {
                return "Password field does not match."
            }
        }
        
        var validity = field.validity; 
        
        // If valid, return false 
        if (validity.valid) { 
            return false; 
        }
        
        // If field is required and empty
        if (validity.valueMissing) {
            return 'Please fill out this field.'; 
        }
        
        // If field's input is not the right type
        if (validity.typeMismatch) {
            switch(field.type) {
                case 'email':
                    return 'Please enter a valid email address.';
                    break;
                case 'url': 
                    return 'Please enter a valid url.';
                    break;
                default:
                    return 'Please use the correct input type.';
            }
        }
        
        // If field is too short
        if (validity.tooShort) {
            return 'Please lengthen this text to ' + field.getAttribute('minLength') + ' characters or more.';
        }
        
        // If field is too long
        if (validity.tooLong) {
            return 'Please short this text to no more than ' + field.getAttribute('maxLength') + ' characters.';
        }
        
        // If number input isn't a number
        if (validity.badInput) {
            return 'Please enter a number.';
        }
        
        // If a number value doesn't match the step interval
        if (validity.stepMismatch) {
            return 'Please select a valid value. Value must be in the increments of ' + field.getAttribute('step') + '.';
        }
        
        // If a number field value is higher than max
        if (validity.rangeOverflow) {
            return 'Please select a value that is no more than ' + field.getAttribute('max') + '.';
        }
        
        // If a number field value is lower than min
        if (validity.rangeUnderflow) {
            return 'Please select a value that is no less than ' + field.getAttribute('min') + '.';
        }
        
        // If field doesn't match specified pattern
        if (validity.patternMismatch) {
            if (field.type == 'password') {
                return 'Password must be at least 6 characters, with numerics and alphabetic characters';
            }
            
            return 'Please match the requested format.';
        }
        
        
        
        // If all else fails
        return 'The value you entered for this field is invalid'; 
    }
    
    var createErrorMsg = function(field, error, selector) {
        var message = field.form.querySelector(selector);
        var id = field.id || field.name;
        if (!message) {
            message = document.createElement('div');
            message.className = 'error-msg';
            message.id = 'error-for-' + id; 
            field.parentNode.insertBefore(message, field.nextSibling);
        }
        
        field.setAttribute('aria-describedby', 'error-for-' + id);
        message.innerHTML = error; 
        return message; 
    };
    
    var showError = function (field, error) {
        
        field.classList.add('input-field--error');
        
        var id = field.id || field.name; 
        
        if (!id) {
            return; 
        }
        
        // Check if error message tag exists 
        // if not create one
        var message = createErrorMsg(field, error, '.error-msg#error-for-' + id); 
        
        // Display error message
        message.className = 'error-msg error-msg--active';
    };
    
    var disable = function(button) {
        button.setAttribute('disabled', true);
    };
    
    var enable = function(button) {
        button.setAttribute('disabled', false);
    }
    
    var removeError = function(field) {
        var id = field.id || field.name; 
        
        if (!id) {
            return; 
        }
        
        field.classList.remove('input-field--error');
        var errorMessage = document.querySelector('.error-msg#error-for-' + id);
        errorMessage.style.display = 'none';
    }
    
    document.addEventListener('blur', function(event) {
       var blurredElement = event.target; 
       var submitBtn = blurredElement.form.querySelector('button.btn--submit');
       console.log(submitBtn);
       if (!blurredElement.form.classList.contains('validate')) {
           return; 
       }
       
       var error = hasError(blurredElement);
       
       if (error) {
           showError(blurredElement, error);
       } else {
           removeError(blurredElement);
       }
    }, true);
    
    
    var forms = document.querySelectorAll('.validate');
    
    // Testing only
    // for (var i = 0; i < forms.length; i++) {
    //     forms[i].setAttribute('novalidate', true);
    // }
    
}(window, window.document));