var Validate = (function () {
    "use strict";
    function Validate() {
        this.alpha = /^([a-zA-Z]+)$/; 
        this.email =/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; 
        this.alphaNum = /^([a-zA-Z0-9_-]+)$/; 
        this.password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/; 
        this.numeric = /^([0-9]+)$/;
        this.name = /^[a-z ,.'-]+$/i;  /* https://stackoverflow.com/questions/2385701/regular-expression-for-first-and-last-name */
    }
    
    Validate.prototype.isValid = function(rule, data) {
        return this[rule].test(data);
    };
    
    return Validate; 
})(); 

var Validator = (function(window, $, Validate) {
    
    if (!window) {
        throw new Error("This code only run on the front end");
    }
    
    if(!$) {
        throw new Error("jQuery file was not found.");
    }
    
    if (!Validate) {
        throw new Error("Validate dependency was not found.");
    } else {
        Validate = new Validate(); 
    }
    
    var init = function(inputData, actionBtn, errorMsg) {
        this.$inputData = $(inputData); 
        this.$actionBtn = $(actionBtn);
        this.$errorMsg = $(errorMsg); 
    };
    
    
    init.prototype.validate = function() {
        var that = this; 
        
        that.$inputData.each(function() {
           var rule = $(this).data("validator");
           $(this).on("blur", function() {
                if(!Validate.isValid(rule, $(this).val())) {
                    $(this).addClass("input--invalid");
                    that.$actionBtn.attr("disabled", true);
                } else {
                    $(this).removeClass("input--invalid");
                    that.$actionBtn.attr("disabled", false);
                }
           });
        });

        that.$actionBtn.click(function(e) {
            var flag = true; 
            
            that.$inputData.each(function(index, value) {
                var rule = $(this).data("validator");

                if (!Validate.isValid(rule, $(this).val())) {
                    flag = false;
                    this.addClass(".input--invalid");
                }
            });
            
            if (!flag) {
                e.preventDefault();
                that.$errorMsg.show(); 
            } else {
                that.$errorMsg.hide(); 
            }
            
        });   
    };
    
    return init; 
    
})(window, window.jQuery, Validate);