(function(window) {
    'use strict';
    if (!window.localStorage) {
        // Throw error 
    }
    
    function has() {}
    function get(key) {
    
        
    }
    function set() {}
})(window);

// Create new cache
function Cache() {
    if (!window.localStorage) {
        throw new Error("Your web browser doesn't support localStorage");
    }
    let now = (new Date()).getTime(); 
    this.expiration = new Date(now + 86400000); // Add one day  
}

Cache.prototype.get = function(key) {
    let now = (new Date()).getTme();
    if (this.isExpire()) {
        this.set(key);
        this.get(key); 
    } else {
        return window.localStorage.getItem(key);    
    } 
};

Cache.prototype.isExpire = function() {
    return (new Date().getTime()) > this.expiration;    
};

Cache.prototype.set = function(key, value) {
    value.expiration = (new Date()).getTime() + 86400000; 
    return window.localStorage.setItem(key, JSON.stringify(value));
}
/* 
Obtaining A Cache Instance - set time 
Retrieving Items From The Cache
Storing Items In The Cache
Removing Items From The Cache
The Cache Helper
*/