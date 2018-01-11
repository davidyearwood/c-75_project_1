<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS75 Finance | @yield('title')</title>
        
        <!-- Revist later -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="background-image--light-circles">
    <!-- Main Navigation -->
    <nav class="nav-bar nav-bar--blue">
        <div class="container--flex">
            <ul class="nav-items">
                <li>
                    <a href="#" class="nav-item nav-item--current-link">
                        <i class="fa fa-line-chart fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">Home</span>
                    </a>
                </li>
                @yield('additional-nav-items')
            </ul>
            <ul class="nav-items">
                <li>
                    <a href="/search" class="nav-item">
                        <i class="fa fa-cart-arrow-down fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">Buy Stocks</span>
                    </a>
                </li>
                <li>
                    <a href="/portfolio" class="nav-item">
                        <i class="fa fa-folder-o fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">Portfolio</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item">
                        <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">My Account</span>
                    </a>
                </li>
            </ul>
            
            <!-- Mobile Navigation -->
            <ul class="nav-items--mobile">
                <li>
                    <a href="#" class="nav-item nav-item--current-link">
                        <i class="fa fa-line-chart fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">Home</span>
                    </a>
                </li>
            </ul>
            
            <ul class="nav-items--mobile">
                <li>
                    <a href="#" class="nav-item nav-item--mobile" id="js-search-icon">
                        <i class="fa fa-search fa-2x" aria-hidden="true"></i>
                        <span class="nav-item__title">Search</span>
                    </a>
                </li>
                
                <li id="js-hover-effect">
                    <a href="#" class="nav-item">
                        <div class="hamburger" id="js-hamburger">
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                        </div>
                    </a>
                </li>
            </ul>
            
        </div>
    </nav>
    
    <form class="searchbar--mobile" id="js-searchbar--mobile">
        <input type="text" name="q" placeholder="Search for stock by symbol" />
        <button class="searchbar__btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
    
    @yield('optional-search')
    
    <div class="grid vertical-space--block">
        <aside class="sub-section">
            <div class="card card--center-text">
                <header class="card__header">
                    <div class="card__icon"><i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i></div>
                    <h4 class="card__title">{{ $user->firstName . " " . $user->lastName }}</h4>
                    <p class="card__sub-title">{{ $user->email }}</p>
                </header>
                <div class="card__body">
                    <section class="card__section">
                        <h4 class="card__title">${{ number_format($user->cash, 2) }}</h4>
                        <p class="card__sub-title">Cash Available</p>
                    </section>
                    
                    <section class="card__section">
                        <h4 class="card__title">${{ number_format($totalAsset, 2) }}</h4>
                        <p class="card__sub-title">Current Portfolio Value</p>
                    </section>
                    
                    <section class="card__section">
                        <h4 class="card__title">${{ number_format($netValue , 2) }}</h4>
                        <p class="card__sub-title">Current Value</p>
                    </section>
                </div>
            </div>
        </aside>
        
        <main class="main-section">
            @include('partials/flash-message')
            
            @yield('main-section')
        </main>
    </div>
    
    <script>
        /* ALL OF THIS NEEDS TO BE REFACTOR AT SOME POINT */
        var hamburger = document.getElementById("js-hamburger");
        var hamburgerLines = document.getElementsByClassName("hamburger__line");
        var hoverEffect = document.getElementById("js-hover-effect"); // revist name
        var searchIcon = document.getElementById("js-search-icon");
        var searchbarMobile = document.getElementById("js-searchbar--mobile");
        
        searchIcon.addEventListener("click", function(e) {
            searchbarMobile.classList.toggle("searchbar--active");  
        });     
        hamburger.addEventListener("click", function(e) {
           hamburger.classList.toggle("hamburger--active");
        });
        
        // Needs to be revist
        hoverEffect.addEventListener("mouseover", toggleBgColor("bg--white"));
        hoverEffect.addEventListener("mouseout", toggleBgColor("bg--white"));
        
        function toggleBgColor(className) {
            return function(e) {
                toggleClasses(hamburgerLines, className);
            }
        }
        
        function toggleClasses(nodes, className) {
            var length = nodes.length; 
            for (var i = 0; i < length; i++) {
                nodes[i].classList.toggle(className);
            }
        }
        
    </script>
</body>
</html>
