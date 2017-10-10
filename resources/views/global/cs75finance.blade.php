<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- This needs to be a variable -->
        <title>CS75 Finance</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700|Roboto:300,400,900" rel="stylesheet">
    </head>
    <body>
        <div class="user-account" id="user-account">
            <ul class="user-account-links">
                <li><a href="#">dyearwoodd@gmail.com</a></li>
                <li><a href="#">Your Profile</a></li>
                <li><a href="#">Log Out</a></li>
            </ul>
        </div>
        
        <div class="container">
            <header>
                <div class="header-links">
                    <li><a href="#">Purchase</a></li>
                    <li><a href="#">Portfolio</a></li>
                </div>
            </header>
            
            <aside>
                <ul class="financial-info">
                    <li class="header">Your Account</li>
                    <li><i class="fa fa-money" aria-hidden="true"></i>Cash <span class="cash">$10,000</span></li>
                    <li>Stock Investment <span class="cash">$4,000</span></li>
                    <li>Net Value <span class="cash">$14,000</span></li>
                </ul>
            </aside>
            

            <div class="main-content">
                <header class="portfolio-title">
                    <h2>Portfolio</h2>
                </header>
                <table>
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Value</th>
                            <th>7-Day Change</th>
                            <th>Sell</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Google Inc.</td>
                            <td>$489.00</td>
                            <td>+112</td>
                            <td><a href="#">sell</a></td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Netflix Inc</td>
                            <td>$89.00</td>
                            <td>+112</td>
                            <td><a href="#">sell</a></td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Apple</td>
                            <td>$889.00</td>
                            <td>+112</td>
                            <td><a href="#">sell</a></td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>