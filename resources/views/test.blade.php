<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        
        @endif
        
        <form action='/test' method='GET'>
            <input type="text" name="symbol" placeholder='Enter Stock Symbol' id='stock-symbol' />
            <input type="submit" value="Submit" id='submit-btn' />
            <form action="/test" method="POST"></form>
        </form>
        
        <div id="stock-container"></div>
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
               console.log(fullPath);
               fetchData(fullPath, cb);
               
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
            	var $stockCard = document.createElement('div');
            	var $stockContainer = document.getElementById('stock-container');
            	var $symbolName = '<input name="stockSymbol" type="hidden" value="' + data.dataset.dataset_code + '">'
            	$stockCard.setAttribute('id', 'stock-card');
            
            	// creates data heading for table
            	var $tableHeaders = _createTableHeader(data.dataset.column_names);
            	var $tableRows = _createTableRows(data.dataset.data);
                
                // 
                var formTags = [
                    '<form action="/test" method="POST" id="stock-card-form">',
                    '<button type="submit">BUY</button>',
                    '<input type="text" name="quantity">',
                    '{{ csrf_field() }}',
                    '<input name="stockSymbol" type="hidden" value="' + data.dataset.dataset_code + '">', 
                    '</form>'
                ];
                
                var $form = formTags.join('');
            	var $header = '<div class="stock-card-title"> <h1>' + data.dataset.name + '</h1> <h2 class="stock-card-price"><span data-value="' + data.dataset.data[0][1] + '" data-symbol="' + data.dataset.dateset_code + '">' + data.dataset.data[0][1] + '</span> <span class="stock-card-currency-type">USD</span></h2></div>';
                
                $stockCard.innerHTML = '<header>' + $header + $form + '</header>' + '<table>' + $tableHeaders + $tableRows + '</table>';
                
                
                if ($stockContainer.firstElementChild) {
                    $stockContainer.replaceChild($stockCard, $stockContainer.firstElementChild); 
                } else {
                    $stockContainer.appendChild($stockCard);
                }
                
            	console.log(data);
            
            }
            
            function stockCard(serverSelf) {
                var form = document.createElement('form');
                form.getAttribute('action', serverSelf);
                form.getAttribute('method', 'GET');
                form.getAttribute('id', 'purchase-stock-card');
                form.getAttribute('id', 'purchase-stock-cards');
            }
            
            function _createTableHeader(data) {
            	var header = '<tr>';
            	for (let i = 0; i < data.length; i++) {
            		header += '<th>' + data[i] + '</th>';
            	}
            	header += '</tr>';
            	return header; 
            }
            
            function _createTableRows(data) {
            	var rows = '';
            	for (let i = 0; i < data.length; i++) {
            		rows += '<tr>';
            		for (let j = 0; j < data[i].length; j++) {
            			rows += '<td>' + data[i][j] + '</td>';
            		}
            		rows += '</tr>'
            	}
            
            	return rows; 
            }
        </script>
    </body>
</html>