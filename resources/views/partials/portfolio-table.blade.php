<table class="material-table">
    <caption>My Portfolio</caption>
    <thead>
        <tr>
            <th>Name</th>
            <th>Symbol</th>
            <th>Purchased Date</th>
            <th>Purchased Price</th>
            <th>Last Trade Cost</th>
            <th>Shares</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        <tr>
            <td>{{ $stock->name }}</td>
            <td>{{ $stock->symbol }}</td>
            <td>{{ $stock->pivot->created_at }}</td>
            <td>{{ $stock->pivot->purchased_price }}</td>
            <td>{{ $stock->last_trade_price }}</td>
            <td>{{ $stock->pivot->quantity }}</td>
            <td><a href="/portfolio/{{ $stock->pivot->id }}" class="btn">Sell</a></td>
        </tr>
        @endforeach
    </tbody>
</table>