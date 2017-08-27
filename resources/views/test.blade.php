<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <form action='/test' method='GET'>
            <input type="text" name="symbol" placeholder='Enter Stock Symbol' id='stock-symbol' />
            <input type="submit" value="Submit" id='submit-btn' />
            <form action="" method=""></form>
        </form>
        
        <script type="text/javascript">
            'use strict';
            var today = new Date();
            var uri = 'https://www.quandl.com/api/v3/datasets/WIKI/';
            var query = '?start_date=' + today.getFullYear() + '-' + today.getMonth() + '-' + (today.getDate() - 1);
            var stockSymbol = document.getElementById('stock-symbol');
            var submitBtn = document.getElementById('submit-btn');
            console.log(stockSymbol);
            
            submitBtn.addEventListener('click', function(e) {
               e.preventDefault();
               var quote = stockSymbol.value; 
               var fullPath = uri + (stockSymbol.value + '.json') + query; 
               fetchData(fullPath, console.log);
               
            });
            
            function fetchData(req, cb) {
                if (window.fetch) {
                    window.fetch(req).then(function(res) {
                        return res.json();
                    }).then(function(data) {
                        cb(data);
                    });
                } else if (window.XMLHttpRequest || window.ActiveXObject('Microsoft.XMLHTTP')) {
                    var httpRequest = new XMLHttpRequest() || new ActiveXObject('Microsoft.XMLHTTP');
                    httpRequest.onreadystatechange = handleAjaxRequest(httpRequest, cb);
                    httpRequest.open('GET', req);
                    httpRequest.send();
                } else {
                    new Error('Unable to make any GET requests to the server.')
                }
            }
            
            function handleAjaxRequest(req, cb) {
                return function () {
                    if(req.readyState === XMLHttpRequest.DONE && req.status === 200) {
                        cb(JSON.parse(req.responseText));
                    } else {
                        return {'errorMessage': 'Unable to make an adjax request'};
                    }
                }
                
            }
            
            function cb(data) {
                var table = document.createElement('table');
                var tds = [];
                var trs = []; 
                for (let i = 0; i < data.dataset.column_names.length; i++) {
                    
                }
                
                for (let i = 0; i < data.dataset.data.length; i++) {
                    // create trs
                    for (let j = 0; j < data.dataset.data[i].length; j++ ) {
                        // add td 
                    }
                    // append dataset to trs
                }
                
            }
            
            function stockCard(serverSelf) {
                var form = document.createElement('form');
                form.getAttribute('action', serverSelf);
                form.getAttribute('method', 'GET');
                form.getAttribute('id', 'purchase-stock-card');
                form.getAttribute('id', 'purchase-stock-cards');
                
                
            }
        </script>
    </body>
</html>