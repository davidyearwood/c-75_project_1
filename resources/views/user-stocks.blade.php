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
        <form action="/portfolio" method="post" class="stock__form" id="stock__form">
            <section>
                {{ csrf_field() }}
                <label for="quantity">Number of shares being sold:</label>
                <input type="number" name="quantity" data-shares="{{ $stock->pivot->quantity }}" min="1" max="{{ $stock->pivot->quantity }}" value="1" required>
                <input type="hidden" name="id" value="{{ $stock->pivot->id }}">
            </section>
            <button type="submit" class="btn btn--red">Sell ({{ $stock->symbol }})</button>
        </form>
    </article>
@endsection