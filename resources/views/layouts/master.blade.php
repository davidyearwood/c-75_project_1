<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Revist later -->
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navigation bar -->
    <header class="navbar">
        <div class="container--flex">
            <div class="navbar__item">
                <form class="searchbar">
                    <input type="text" name="q"/>
                    <button class="searchbar__btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <nav class="navbar__item">
                <ul class="nav-links">
                    <li class="username">{{ $user->firstName . " " . $user->lastName }}</li>
                    <li>
                        <a href="/portfolio" class="nav-item">
                            <i class="fa fa-folder-o fa-3x" aria-hidden="true"></i>
                            <span class="nav-item__title">Portfolio</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search" class="nav-item">
                            <i class="fa fa-cart-arrow-down fa-3x" aria-hidden="true"></i>
                            <span class="nav-item__title">Buy Stocks</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav-item">
                            <i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i>
                            <span class="nav-item__title">My Account</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
