@extends('global.parent')

@section('title', 'Portfolio')

@section('main')
        @parent
        <header class="main-content__header">
            <h2 class="main-content__title">Portfolio</h2>
        </header>
        <table class="portfolio">
            <thead class="portfolio__header">
                <tr>
                    <th>Symbol</th>
                    <th>Purchased Price</th>
                    <th>7-Day Change</th>
                    <th>Sell</th>
                    <th>Quantity</th>
                    <th>Purchased Date</th>
                    <th>Current Price</th>
                </tr>
            </thead>
            <tbody class="portfolio__body">
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->symbol }}</td>
                        <td class="portfolio__money">{{ $stock->pivot->purchased_price}}</td>
                        <td>+112</td>
                        <td><a href="#">sell</a></td>
                        <td>{{ $stock->pivot->quantity }}</td>
                        <td><?= date('M d, Y', strtotime($stock->pivot->created_at)) ?></td>
                        <td>{{ $stock->current_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection