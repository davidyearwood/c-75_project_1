<h1>Hello!</h1>
<ul>
@foreach ($stocks as $stock)
    <li>{{ $stock->name }} - {{ $stock->pivot->id }} </li>
    <form action='/purchase' method='POST'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" value="{{ $stock->pivot->id }}" name="id" />
        <select name="quantity" id="quantity">           
            @for ($amount = 1; $amount <= $stock->pivot->quantity; $amount++)
                <option value="{{ $amount }}">{{ $amount }}</option>
            @endfor
        </select>
        <input type="hidden" value="{{ $stock->pivot->id }}" name="pid">
        <input type="submit" value="Submit"/>
    </form>
@endforeach
</ul>
