@extends('layouts.material')

@section('title', 'Search')

@section('main-section')
    <div class="container">
        @include('partials.search-bar')
        
        @if(isset($stock))
            @include('partials.stock-certificate')
        @endif 
    </div>
@endsection