<table class="material-table">
    <caption>My Portfolio</caption>
    <thead>
        <tr>
            <!--<th>Name</th>-->
            <th scope="col">Symbol</th>
            <th scope="col">Purchased Date</th>
            <th scope="col">Purchased Price</th>
            <th scope="col">Last Trade Cost</th>
            <th scope="col">Shares</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        <tr>
            <td>{{ $stock->symbol }}</td>
            <td>{{ $stock->pivot->created_at }}</td>
            <td class="material__td--numeric">${{ $stock->pivot->purchased_price }}</td>
            <td class="material__td--numeric">${{ $stock->last_trade_price }}</td>
            <td>{{ $stock->pivot->quantity }}</td>
            <td><a href="/portfolio/{{ $stock->pivot->id }}" class="btn">Sell</a></td>
        </tr>
        @endforeach
    </tbody>
</table>