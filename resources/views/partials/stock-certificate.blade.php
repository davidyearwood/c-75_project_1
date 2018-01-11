<div class="stock-certificate card">
    <header class="stock-certificate__header">
        <h2 class="stock-name">{{ substr($stock['name'], 0, strpos($stock['name'], ")") + 1 ) }}</h2>
    </header>
    <section class="stock-certificate__action">
        <h3 class="stock-price">${{ $stock['price'] }}</h3>
        <form action="/search" method="POST" class="stock-certificate__form">
            {{ csrf_field() }}
            <div class="shares-container">
                <label for="shares">Shares:</label>
                <input id="shares" class="stock-shares" type="number" name="quantity" data-shares="" min="1" max="99" value="1" required>
            </div>
            <button type="submit" class="btn--buy">Buy {{ strtoupper($stock['symbol']) }}</button>
            <input type="hidden" name="stock" value="{{ strtoupper($stock['symbol']) }}">
        </form>        
    </section>
</div>