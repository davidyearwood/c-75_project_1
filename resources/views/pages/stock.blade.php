@extends('layouts.material')


@section('title', $stock->symbol)

@section('main-section')
    <div class="container">
        @if(isset($stock))
            <div class="stock-certificate card">
                <header class="stock-certificate__header">
                    <h2 class="stock-name">{{ substr($stock['name'], 0, strpos($stock['name'], ")") + 1 ) }}</h2>
                    <p class="stock-price">${{ $stock->last_trade_price }}</p>
                </header>
                <section class="stock-certificate__action">
                    <form action="/portfolio" method="POST" class="stock-certificate__form">
                        {{ csrf_field() }}
                        <div class="shares-container">
                            <label for="shares">Shares:</label>
                            <input id="shares" class="stock-shares" type="number" name="quantity" data-shares="" min="1" max="{{ $stock->pivot->quantity }}" value="1" required>
                            <input type="hidden" value="{{ $stock->pivot->id }}" name="id">
                        </div>
                        <button type="submit" class="btn btn--full-width btn--buy">Sell {{ strtoupper($stock['symbol']) }}</button>
                        <input type="hidden" name="stock" value="{{ strtoupper($stock['symbol']) }}">
                    </form>        
                </section>
            </div>
        @endif 
    </div>
@endsection