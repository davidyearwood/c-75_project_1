@extends('layouts.auth') @section('main-section')
<div class="auth-card">
    <header class="auth-header">                            
        <i class="fa fa-line-chart fa-5x auth-header__icon" aria-hidden="true"></i> 
        <h1 class="auth-header__title">C$75 Finance</h1>
    </header>
    
    @if ($errors->has('firstName') || $errors->has('lastName') || $errors->has('email') || $errors->has('password') || $errors->has('password_confirmation'))
        <div class="msg-block">
            <span class="msg--required"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> All fields are required.</span>
        </div>
    @endif
    
    <div class="msg-block" id="js-msg-block" style="display: none">
        <span class="msg--required"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> All fields are required.</span>
    </div>
    <!--method="POST" action="{{ url('/register') }}"-->
    <form role="form"  class="auth-form validate" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
            <label for="last-name">Enter your first name:</label>
            <input id="first-name" type="text" id="input-first-name" class="input-field" name="firstName" value="{{ old('firstName') }}" required pattern="^[a-zA-Z ]{2,30}$">               
        </div>

        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
            <label for="name">Enter your last name:</label>
            <input id="last-name" type="text" id="input-last-name" class="input-field" name="lastName" value="{{ old('lastName') }}" required pattern="^[a-zA-Z ]{2,30}$"> 
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Enter your e-mail address:</label>
            <input id="email" type="email" id="input-email" class="input-field" name="email" value="{{ old('email') }}" required> 
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Enter your password:</label>
            <input id="password" type="password" id="input-password" class="input-field" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" min="6" required> 
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm">Confirm your password</label>
            <input id="input-password-confirm" type="password" class="input-field" name="password_confirmation" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" min="6" required>
        </div>

        <button type="submit" class="btn btn--raised btn--centered btn--submit">Register</button>    
    </form>
    <a href="{{ url('/login')}}" class="auth-link">Already have an account? Login here.</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/pollyfill.js"></script>
<script type="text/javascript" src="/js/ConstraintAPI.js"></script>
@endsection