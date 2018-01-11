@extends('layouts.master')

@section('title', 'Portfolio')

@section('additional-nav-items')
    @include('partials.nav-search-bar')
@endsection

@section('main-section')
    @include('partials.portfolio-table')
@endsection