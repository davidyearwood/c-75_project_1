 <div class="card--table">
            <header class="table__title">
                <h2>Portfolio</h2>
            </header>
            <div class="table">
                <div class="table__header">
                    <tr class="table__row">
                        <th>Symbol</th>
                        <th>Purchased Date</th>
                        <th>Purchased Price</th>
                        <th>Last Trade Cost</th>
                        <th>Shares</th>
                        <th></th>
                    </tr>
                </div>
                    @foreach($stocks as $stock)
                        <form action="" class="table__row">
                            <span class="table__data">{{ $stock->symbol }}</span>
                            <span class="table__data">{{ $stock->pivot->created_at }}</span>
                            <span class="table__data">{{ $stock->pivot->purchased_price}}</span>
                            <span class="table__data">{{ $stock->last_trade_price}} </span>
                            <span class="table__data"><input type="number" name="quantity" min="1" max="{{ $stock->pivot->quantity }}" value="{{ $stock->pivot->quantity }}" /></span>
                            <span class="table__data"><button type="submit" class="btn">sell</button></span>
                            <input type="hidden" name="id" value="{{ $stock->pivot->id }}">
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
        