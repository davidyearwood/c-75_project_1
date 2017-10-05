var CacheError = (function() {
    function DoesntExistError(message) {
        this.name = 'CacheDoesntExistError';
        this.message = message;
    }
    
    DoesntExistError.prototype = Object.create(Error.prototype);
    
    function KeyDoesntExistError(message) {
        this.name = 'CacheDoesntExistError'
        this.message = message; 
    }
    
    KeyDoesntExistError.prototype = Object.create(Error.prototype);
    
    function KeyExpiredError(message) {
        this.name = 'CacheKeyExpiredError';
        this.message = message;
    }
    
    KeyExpiredError.prototype = Object.create(Error.prototype);
    
    return {
        CacheDoesntExistError: DoesntExistError, 
        CacheKeyDoesntExistError: KeyDoesntExistError,
        CacheKeyExpiredError: KeyExpiredError
    };
    
})();