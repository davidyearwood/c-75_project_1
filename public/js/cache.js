var Cache = (function(window) {
    'use strict';
    if (!window.localStorage) {
        throw new LocalStorageException("Your browser doesn't support Local Storage");
    } else {
        var myStorage = window.localStorage; 
    }
    
    // Private function
    function _addHours(date, hours) {
        return new Date(date.getTime() + (hours * 60 * 60 * 1000));
    }
    
    function LocalStorageException(message) {
        this.name = 'Local Storage Exception';
        this.message = message; 
    }
    
    function has(key) {
        return myStorage.getItem(key) !== null;
    }
    
    function get(key) {
        if (!has(key)) { throw new Error("There is no key of that name stored in the Cache"); }
        var value = JSON.parse(myStorage.getItem(key));
        var now = new Date(); 
        if (new Date(value.expiration).getTime() > now.getTime()) {
            myStorage.removeItem(key);
            return false;
        }
        return value; 
    }
    
    function set(key, value) {
        if (has(key)) { return get(key); }
        
        var value = JSON.stringify({
            value: value,
            expiration: _addHours(new Date(), 24)  
        });
        
        return myStorage.setItem(key, value);
    }
    
    return { 
        get: get,
        set: set,
        has: has
    }; 
})(window);

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