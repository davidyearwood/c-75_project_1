@extends('layouts.material')

@section('title', 'Portfolio')

@section('main-section')
    <div class="container">
    @include('partials.portfolio-table')
    </div>
@endsection