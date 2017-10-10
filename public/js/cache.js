var Cache = (function(window, Modernizr) {
    'use strict';
    var DAY_IN_HOURS = 1; 
 
    // Private Variables
    if (Modernizr.localstorage) {
        var myStorage = window.localStorage; 
    } else {
        throw new DoesntExistError("Your browser doesn't support Local Storage");
    }
    
    // Private function
    function _addHoursToDate(date, hours) {
        var miliseconds = 1000; 
        var seconds = 60;
        var minutes = 1;
        return new Date(date.getTime() + (minutes * seconds * miliseconds));
    }
    
    function _isExpired(expirationDate) {
        var now = new Date(); 
        return now.getTime() > expirationDate;  
    }
    
    function has(key) {
        return myStorage.getItem(key) !== null;
    }
    
    function get(key) {
        
        if (!has(key)) { 
            throw new KeyDoesntExistError('There is no key with the name ' + key + ' in your local storage'); 
        }
        
        var data = JSON.parse(myStorage.getItem(key));
        var now = new Date();
        var expirationDateInMiliseconds = new Date(data.expiration).getTime(); 
        
        if (_isExpired(expirationDateInMiliseconds)) {
            myStorage.removeItem(key);
            throw new KeyExpiredError(key + ' has expired.');
        }
        
        return data; 
    }
    
    function set(key, value) {
        if (has(key)) {
            try {
                var data = get(key);
            } catch(error) {
                if (error instanceof KeyExpiredError) {
                    set(key, value);
                }
            }
        }
        
        var value = JSON.stringify({
            value: value,
            expiration: _addHoursToDate(new Date(), DAY_IN_HOURS)  
        });
        
        return myStorage.setItem(key, value);
    }
    
    return { 
        get: get,
        set: set,
        has: has
    }; 
})(window, Modernizr);

/* 
Obtaining A Cache Instance - set time 
Retrieving Items From The Cache
Storing Items In The Cache
Removing Items From The Cache
The Cache Helper
*/