<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS75 Finance | @yield('title')</title>
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700|Roboto:300,400,900" rel="stylesheet">
    </head>
    <body>
        <div class="sidebar-layout">
            <div class="sidebar-layout__header user-account" id="user-account">
                <ul class="user-account__links">
                    <li>{{ $user->email }}</li>
                    <li><a href="#">Your Profile</a></li>
                    <li><a href="#">Log Out</a></li>
                </ul>
            </div>
            
            <header class="sidebar-layout__header">
                <figure class="logo-container">
                    <img src="http://via.placeholder.com/250x100" alt="CS75 Finance Logo" class="logo-container__logo">
                </figure>
                <nav class="tabs">
                    <ul class="tabs__links">
                        <li><a href="#">Purchase</a></li>
                        <li><a href="/portfolio">Portfolio</a></li>
                    </ul>
                </nav>
            </header>
            <aside class="sidebar-layout__sidebar sidebar-layout--blue">
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
            <main class="sidebar-layout__main">
                @yield('main')
            </main>
        </div>
    </body>
</html>