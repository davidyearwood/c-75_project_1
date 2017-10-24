@extends('global.sidebar-layout')

@section('title', 'Portfolio')

@section('main')
    @parent
    <article class="stock">
        <header class="stock__header">
            <h2>Google Inc. ({{ $stock->symbol }})</h2>
            <p>You own {{ $stock->pivot->quantity }} shares</p>
        </header>
        <section class="stock__current-price">
            <h3>${{ $stock->current_price }} <span>+0.07 | 0.11%</span></h3>
            <p class="stock__last-updated">Last Updated: 08/11/15</p>
        </section>
        <section class="stock__info">
            <ul>
                <li>Prev Close: 66.55</li>
                <li>Day's Open: 66.12</li>
                <li>Volume: 15.02k</li>
                <li>Range: 99.2 - 88.5</li>
            </ul>
        </section>
        <form action="#" method="post" class="stock__form" id="stock__form">
            <section>
                <label for="shares">Number of shares being sold:</label>
                <input type="number" name="shares" data-shares="{{ $stock->pivot->quantity }}" min="1" max="{{ $stock->pivot->quantity }}" required>
            </section>
            <button type="submit" class="btn">Sell ({{ $stock->symbol }})</button>
        </form>
    </article>
@endsection