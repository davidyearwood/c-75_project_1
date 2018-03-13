<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS75 Finance | @yield('title')</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,400,700|Titillium+Web:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/stylesheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body class="bg--wallpaper">
        
        <header class="bg--primary-theme global-header">
            <div class="container">
                <section class="utility">
                    <a href="/" class="logo">
                        <h1>
                            <i class="fa fa-line-chart fa-2x logo__icon" aria-hidden="true"></i> 
                            <span class="logo__text">CS75 Finance</span>
                        </h1>
                    </a>
                    <a href="#" class="user-name">
                        <span class="user-name__text">{{ $user->firstName }} {{ $user->lastName }}</span>
                        <i class="fa fa-user-circle-o fa-2x user-name__icon" aria-hidden="true"></i>
                    </a>
                </section>
                <section class="user-information">
                    <h2 class="page-title"><!--@yield('page-title')--> Portfolio</h2>
                    <ul class="finance-info">
                        <li>
                            <span class="finance-info__cash">${{ number_format($user->cash, 2) }}</span>
                            <span class="finance-info__text">Cash Available</span>
                        </li>
                        <li>
                            <span class="finance-info__cash">${{ number_format($totalAsset, 2) }}</span>
                            <span class="finance-info__text">Portfolio Value</span>
                        </li>
                        <li>
                            <span class="finance-info__cash">${{ number_format($netValue , 2) }}</span>
                            <span class="finance-info__text">Total Net Worth</span>
                        </li>
                    </ul>
                </section>
            </div>
            <nav>
                <div class="container">
                    <ul class="nav-links">
                        <li class="nav-links__item"><a href="/">Portfolio</a></li>
                        <li class="nav-links__item"><a href="/search">Search for a stock</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <main>
            <div id="js-alert-message">
                @include('partials/flash-message')
            </div>
            @yield('main-section')
        </main>
    </body>
</html>
