var Cache = (function(window, Modernizr) {
    'use strict';
    // Private Variables
    var DAY_IN_HOURS = 24;
    
    if (Modernizr.localStorage) {
        var myStorage = window.localStorage; 
    } else {
        throw new LocalStorageDoesntExistException("Your browser doesn't support Local Storage");
    }
    
    // Private function
    function _addHoursToDate(date, hours) {
        var miliseconds = 1000; 
        var seconds = 60;
        var minutes = 60;
        return new Date(date.getTime() + (hours * minutes * seconds * miliseconds));
    }
    
    function isExpired(expirationDate) {
        var now = new Date(); 
        return expirationDate > now.getTime();  
    }
    
    // Exception Handlers
    function LocalStorageDoesntExistException(message) {
        this.name = 'Local Storage Exception';
        this.message = message; 
    }
    
    function LocalStorageKeyDoesntExistException(message) {
        this.name = 'Key doesn \'t exist'; 
        this.message = message; 
    }
    
    function LocalStorageKeyExpiredException(message) {
        this.name = 'Key has expired';
        this.message = message; 
    }
    
    function has(key) {
        return myStorage.getItem(key) !== null;
    }
    
    function get(key) {
        
        if (!has(key)) { 
            throw new LocalStorageKeyDoesntExistException('There is no key with the name ' + key + ' in your local storage'); 
        }
        
        var data = JSON.parse(myStorage.getItem(key));
        var now = new Date();
        var expirationDateInMiliseconds = new Date(data.expiration).getTime(); 
        
        if (isExpired(expirationDateInMiliseconds)) {
            myStorage.removeItem(key);
            throw new LocalStorageKeyExpiredException(key + ' has expired. Re-add key');
        }
        
        return data; 
    }
    
    function set(key, value) {
        if (has(key)) {
            try {
                var data = get(key);
            } catch(error) {
                if (error instanceof LocalStorageKeyExpiredException) {
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

var CacheCopy = Cache; 
CacheCopy.set('GOOG', {'orginal_price' : 32.89, 'name': 'GOOG'});
console.log(CacheCopy.get('GOOG'));
/* 
Obtaining A Cache Instance - set time 
Retrieving Items From The Cache
Storing Items In The Cache
Removing Items From The Cache
The Cache Helper
*/