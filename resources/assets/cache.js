var Cache = (function(window) {
    'use strict';
    if (!window.localStorage) {
        throw new LocalStorageException("Your browser doesn't support Local Storage");
    } else {
        var myStorage = window.localStorage; 
    }
    
    function addHours(date, hours) {
        return new Date(date.getTime() + (hours * 60 * 60 * 1000));
    }
    
    function LocalStorageException(message) {
        this.name = 'Local Storage Exception';
        this.message = message; 
    }
    
    function init() {
        var date = new Date();
        var now = date.getTime();     
    }

    function has() {}
    function get(key) {
        if (!has(key)) { throw new Error("There is no key of that name stored in the Cache"); }
        var value = JSON.parse(myStorage.getItem(key));
        
    }
    function set(key, value) {
        var value = JSON.stringify({
            value: value,
            expiration: addHours(new Date(), 24)  
        });
        
        return myStorage.setItem(key, value);
    }
    
    return {init: init}; 
})(window);

/* 
Obtaining A Cache Instance - set time 
Retrieving Items From The Cache
Storing Items In The Cache
Removing Items From The Cache
The Cache Helper
*/