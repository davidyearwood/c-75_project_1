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
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700|Roboto:300,400,900" rel="stylesheet">
    </head>
    <body>
        
        <div class="container">
            <div class="user-account" id="user-account">
                <ul class="user-account__links">
                    <li>dyearwoodd@gmail.com</li>
                    <li><a href="#">Your Profile</a></li>
                    <li><a href="#">Log Out</a></li>
                </ul>
            </div>
            <nav class="tabs">
                <ul class="tabs__links">
                    <li><a href="#">Purchase</a></li>
                    <li><a href="#">Portfolio</a></li>
                </ul>
            </nav>
            <aside class="side">
                <ul class="financial-info">
                    <li class="financial-info__header">Your Account</li>
                    <li>
                        <i class="fa fa-money" aria-hidden="true"></i>
                        <span class="financial-info__header">Cash</span> 
                        <span class="financial-info__cash">$10,000</span>
                    </li>
                    <li>
                        <span class="financial-info__header">Stock Investment</span> 
                        <span class="financial-info__cash">$4,000</span>
                    </li>
                    <li>
                        <span class="financial-info__header">Net Value</span>
                        <span class="financial-info__cash">$14,000</span>
                    </li>
                </ul>
            </aside>
            <div class="main-content main-content--red">
                <header>
                    <h2 class="main-content__title">Portfolio</h2>
                </header>
                <table class="portfolio">
                    <thead class="portfolio__header">
                        <tr>
                            <th>Symbol</th>
                            <th>Value</th>
                            <th>7-Day Change</th>
                            <th>Sell</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="portfolio__body">
                        <tr>
                            <td>Google Inc.</td>
                            <td class="portfolio__money">$489.00</td>
                            <td>+112</td>
                            <td><a href="#">sell</a></td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Netflix Inc</td>
                            <td class="portfolio__money">$89.00</td>
                            <td>+112</td>
                            <td><a href="#">sell</a></td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Apple</td>
                            <td class="portfolio__money">$889.00</td>
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