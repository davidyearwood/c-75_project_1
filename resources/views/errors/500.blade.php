@extends('layouts.error')

@section('title', 'HTTP Status Code: 500') 

@section('main-section')
    <div class="http-error">
        <h1 class="http-error__title">Internal Server Error.</h1>
        <p class="http-error__msg">{{ $exception->getMessage() }}</p>
        <a href="/" class="btn btn--raised">Go to homepage</a>
    </div>
@endsection
