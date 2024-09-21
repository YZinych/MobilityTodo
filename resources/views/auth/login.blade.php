@extends('todos.layouts.layout')

@section('content')
<div class="container mt-5 h-100 ">
    <div class="row h-100">

        <div class="d-flex justify-content-center align-items-center" style="width: 100% ">
            <form class="form-signin form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email"  placeholder="Email address" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <div class="help-block small mt-1 mb-2">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <div class="help-block small mt-1 mb-2">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <a href="{{ route('register') }}" class="btn btn-lg btn-secondary btn-block" role="button">Registration</a>

            </form>
        </div>


    </div>
</div>
@endsection
