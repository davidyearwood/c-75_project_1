var Util = (function(window) {
    
    var util = {
        hasFormValidation: function() {
            return (typeof document.createElement('input').checkValidity == 'function');
        }  
    };
    
    return util; 
    
})(window);