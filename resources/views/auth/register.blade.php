@extends('todos.layouts.layout')

@section('content')
<div class="container mt-5 h-100 ">
    <div class="row h-100">

        <div class="d-flex justify-content-center align-items-center" style="width: 100% ">

            <form class="form-signin form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <h1 class="h3 mb-3 font-weight-normal">Registration</h1>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <div class="help-block small mt-1 mb-2">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="E-Mail Address" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <div class="help-block small mt-1 mb-2">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                <input type="password" placeholder="Password" class="form-control mb-0" name="password" required>

                @if ($errors->has('password'))
                    <div class="help-block small mt-1 mb-2">
                        {{ $errors->first('password') }}
                    </div>
                @endif

            </div>

            <div class="form-group">
                <input type="password" class="form-control mb-0" placeholder="Confirm Password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </form>
        </div>

    </div>
</div>
@endsection
