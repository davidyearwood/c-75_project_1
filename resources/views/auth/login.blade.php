@extends('layouts.not-login')

@section('main-section')

<div class="auth-card">
    <header class="auth-header">                            
        <i class="fa fa-line-chart fa-5x auth-header__icon" aria-hidden="true"></i> 
        <h1 class="auth-header__title">C$75 Finance</h1>
    </header>
    
     <form role="form" method="POST" action="{{ url('/login') }}" class="auth-form">
        {{ csrf_field() }}
    
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Enter your e-mail address:</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
    
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    
    
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Enter your password:</label>
            <input id="password" type="password" class="form-control" name="password">
            
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        
        <button type="submit" class="btn btn--raised btn--centered">Login</button>    
    </form>
    
    <a href="{{ url('/register')}}" class="auth-link">Don't have credentials? Register for an account.</a>
</div>
@endsection