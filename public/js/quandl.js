var Quandl = (function(window) {
    'use strict';
    // Exception Handlers
    function LocalStorageDoesntExistException(message) {
        this.name = 'Local Storage Exception';
        this.message = message; 
    }
    LocalStorageDoesntExistException.prototype = Object.create(Error.prototype);
    LocalStorageDoesntExistException.prototype.name = 'LocalStorageDoesntExistException';
    
    function LocalStorageKeyDoesntExistException(message) {
        this.name = 'Key doesn \'t exist'; 
        this.message = message; 
    }
    LocalStorageKeyDoesntExistException.prototype = Object.create(Error.prototype);
    LocalStorageKeyDoesntExistException.prototype.name = 'LocalStorageKeyDoesntExistException';
    
    function LocalStorageKeyExpiredException(message) {
        this.name = 'LocalStorageKeyExpiredException';
        this.message = message;
        this.stack = (new Error()).stack;
    }
    LocalStorageKeyExpiredException.prototype = Object.create(Error.prototype);
    LocalStorageKeyExpiredException.prototype.name = 'LocalStorageKeyExpiredException';
    
    var today = new Date(); 
    var uri = 'https://www.quandl.com/api/v3/datasets/WIKI/';
    var query = '?start_date=' + today.getFullYear() + '-' + today.getMonth() + '-' + (today.getDate() - 1);
    var cache = {};
    
    function init(options) {
        cache = options.cache;
    }
    
    function _setCache(c) {
        cache = c; 
    }
    
    function _setFullPath(symbol) {
        return uri + symbol + query;     
    }
    
    function fetchData(symbol, cb) {
        symbol = symbol.toUpperCase();
        var fullPath = _setFullPath(symbol); ;
        if (cache.has(symbol)) {
            console.log('I passed the has method');
            try { 
                return cb(cache.get(symbol));
            } catch(e) {
                console.log(e);
                return fetchData(symbol, cb);
            }
        } 

        if (window.fetch) {
            console.log('I passed the fetch method');
            window.fetch(fullPath).then(function(res) {
                return res.json()   
            }).then(function(data) {
                cache.set(symbol, data);
                return cb(cache.get(symbol)); 
            });          
        } else if (window.XMLHttpRequest || window.ActiveXObject('Microsoft.XMLHTTP')) {
            var httpRequest = new XMLHttpRequest() || new ActiveXObject('Microsoft.XMLHTTP');
            httpRequest.onreadystatechange = _handleAjaxRequest(fullPath, cb);
            httpRequest.open('GET', fullPath
            );
            
            httpRequest.send(); 
        } else {
            new Error('Unable to retrieve stock from %s', fullPath);
        }
    }; 
    
    function _handleAjaxRequest(req, cb) {
        return function() {
            if(req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                cb(JSON.parse(req.responseText));
            } else {
                new Error('Unable to make AJAX Request');
            }    
        }
    }
    
    return {
        init: init, 
        fetch: fetchData
    };
})(window);
