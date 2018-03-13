@extends('layouts.error')

@section('title', 'HTTP Status Code: 400') 

@section('main-section')
    <div class="http-error">
        <h1 class="http-error__title">Page not found.</h1>
        <p class="http-error__msg">{{ $exception->getMessage() }}</p>
    </div>
    <a href="/" class="btn btn--raised">Go to homepage</a>
@endsection