@extends('layouts.frontLayout.front_design')
@section('content')
    <style>
        .error {
            color: red;
            /* background: pink; */
        }

        label,
        input,
        button {
            border: 0;
            margin-bottom: 3px;
            display: block;
            width: 100%;
        }

        .common_box_body {
            padding: 15px;
            border: 12px solid #28BAA2;
            border-color: #28BAA2;
            border-radius: 15px;
            margin-top: 10px;
            background: #d4edda;
        }
    </style>

    <section id="form" style="margin-top:30px;"><!--form-->
        <div class="container">
            <div class="row">
                <div class="table-responsive cart_info">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                </div>
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Login to your account</h2>
                        <form id="loginForm" name="loginForm" action="{{ url('/user-login') }}" method="POST">
                            {{ csrf_field() }}
                            <input name="email" type="email" placeholder="Email Address" required />
                            <input name="password" type="password" placeholder="Password" required />
                            <!-- <span>
                                    <input type="checkbox" class="checkbox">
                                    Keep me signed in
                                </span> -->
                            <button type="submit" class="btn btn-default">Login</button><br>
                            <a href="{{ url('forgot-password') }}">Forgot Password ?</a>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>New User Signup!</h2>
                        <form id="registerForm" name="registerForm" action="{{ url('/user-register') }}" method="POST">
                            {{ csrf_field() }}
                            <input id="name" name="name" type="text" placeholder="Name" />
                            <input id="email" name="email" type="email" placeholder="Email Address" />
                            <input id="myPassword" name="password" type="password" placeholder="Password" />
                            <button type="submit" class="btn btn-default">Signup</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection
