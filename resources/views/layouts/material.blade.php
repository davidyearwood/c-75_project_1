<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS75 Finance | @yield('title')</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        
        <header class="bg--primary-theme">
            <div class="container">
                <section class="utility">
                    <!-- Revist to make this more accessible -->
                    <!--<div id="js-hover-effect" class="inactive">-->
                    <!--    <a href="#" class="nav-item">-->
                    <!--        <div class="hamburger" id="js-hamburger">-->
                    <!--            <span class="hamburger__line"></span>-->
                    <!--            <span class="hamburger__line"></span>-->
                    <!--            <span class="hamburger__line"></span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <!-- Revist to make this more accessible -->
                    <div class="logo">
                        <h1><i class="fa fa-line-chart fa-2x" aria-hidden="true"></i> CS75 Finance</h1>
                    </div>
                    <section class="user-account">
                        <span class="nav-item__title">{{ $user->firstName }} {{ $user->lastName }}</span>
                        <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
                    </section>
                </section>
                <section class="financial-information">
                    <h2 class="page-title">@yield('page-title')</h2>
                    <ul class="networth">
                        <li>${{ number_format($user->cash, 2) }}<br>Cash Available</li>
                        <li>${{ number_format($totalAsset, 2) }}<br>Portfolio Value</li>
                        <li>${{ number_format($netValue , 2) }}<br>Total Net Worth</li>
                    </ul>
                </section>
            </div>
        </header>
        
        <nav class="">
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Trade</a></li>
                <li><a href="#">Buy</a></li>
            </ul>
        </nav>
        
        <main>
            @include('partials/flash-message')
            @yield('main-section')
        </main>
    </body>
</html>
