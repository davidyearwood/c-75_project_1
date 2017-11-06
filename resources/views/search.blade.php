@extends('global.sidebar-layout')

@section('title', 'Portfolio')

@section('main')
    @parent
    <header class="main-content__header">
        <h2 class="main-content__title">Search for a stock</h2>
    </header>
    
    <form action="/search" method="GET">
        <input type="text" name="q" required autofocus>
        <button type="submit">Search</button>
    </form>
    
    @if (isset($error))
        <h3>{{ $error['message']}}</h3>
    @endif 
    
    @if (isset($stock['name']))
    <article class="stock">
        <header class="stock__header">
            <h2>{{ preg_split("[Prices,]", $stock['name'])[0] }}</h2>
        </header>
        <section class="stock__current-price">
            <h3>${{ $stock['price'] }} <span>+0.07 | 0.11%</span></h3>
            <p class="stock__last-updated">Last Updated: 08/11/15</p>
        </section>
        <section class="stock__info">
            <ul>
                <li>Prev Close: ${{ number_format($stock['close'], 2) }}</li>
                <li>Day's Open: ${{ number_format($stock['open'],2) }}</li>
                <li>Range: ${{ number_format($stock['high'], 2) }} - ${{ number_format($stock['low'], 2) }}</li>
                <li>Volume: {{ number_format($stock['volume']) }}</li>
            </ul>
        </section>
        <form action="/search" method="post" class="stock__form" id="stock__form">
            <section>
                {{ csrf_field() }}
                <label for="quantity">Number of shares being sold:</label>
                <input type="number" name="quantity" data-shares="" min="1" max="99" value="1" required>
                <input type="hidden" name="stock" value="{{ strtoupper($stock['symbol']) }}">
            </section>
            <button type="submit" class="btn btn--red">Buy ({{ strtoupper($stock['symbol']) }})</button>
        </form>
    </article>
    @endif
@endsection