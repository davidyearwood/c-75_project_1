@extends('layouts.auth')

@section('main-section')

<div class="auth-card">
    <header class="auth-header">                            
        <i class="fa fa-line-chart fa-5x auth-header__icon" aria-hidden="true"></i> 
        <h1 class="auth-header__title">C$75 Finance</h1>
    </header>
    
    @if ($errors->has('email') || $errors->has('password'))
        <div class="msg-block">
            <span class="msg--required"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Invalid email or password.</span>
        </div>
    @endif
 
     <form role="form" method="POST" action="{{ url('/login') }}" id="auth-form" class="validate auth-form">
        {{ csrf_field() }}
        
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Enter your e-mail address:</label>
            <input type="email" id="input--email" class="input-field" name="email" value="{{ old('email') }}" required>
        </div>
    
    
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Enter your password:</label>
            <input id="input--password" type="password" class="input-field" name="password" required>
        </div>
        
        <button type="submit" class="btn btn--raised btn--centered btn--submit">Login</button>    
    </form>
    
    <a href="{{ url('/register')}}" class="auth-link">Don't have credentials? Register for an account.</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/pollyfill.js"></script>
<script type="text/javascript" src="/js/ConstraintAPI.js"></script>
@endsection