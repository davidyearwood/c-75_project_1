@extends('global.parent')

@section('main')
        @parent
        <header class="main-content__header">
            <h2 class="main-content__title">Portfolio</h2>
        </header>
        <table class="portfolio">
            <thead class="portfolio__header">
                <tr>
                    <th>Symbol</th>
                    <th>Value</th>
                    <th>7-Day Change</th>
                    <th>Sell</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody class="portfolio__body">
                <tr>
                    <td>Google Inc.</td>
                    <td class="portfolio__money">$489.00</td>
                    <td>+112</td>
                    <td><a href="#">sell</a></td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Netflix Inc</td>
                    <td class="portfolio__money">$89.00</td>
                    <td>+112</td>
                    <td><a href="#">sell</a></td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Apple</td>
                    <td class="portfolio__money">$889.00</td>
                    <td>+112</td>
                    <td><a href="#">sell</a></td>
                    <td>5</td>
                </tr>
            </tbody>
        </table>
@endsection