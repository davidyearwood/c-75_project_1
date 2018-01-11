@extends('layouts.master')

@section('title', 'Search')

@section('optional-search')
    @include('partials.search-bar')
@endsection

@section('main-section')
    @if(isset($stock))
        @include('partials.stock-certificate')
    @endif 
@endsection 
