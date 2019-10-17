@extends('layouts.app')

@section("title", "Login")

@push('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@endpush

@push('after-scripts')
    <script>
        $(document).ready(function () {
            //your code here
        });
    </script>
    <script src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('js/demo_pages/login.js') }}"></script>
@endpush

@section('content')
    <!-- Page content -->
    <div class="page-content" style="margin: 60px;">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Login card -->
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>
                                <h5 class="mb-0">Login to your account</h5>
                                <span class="d-block text-muted">Your credentials</span>
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="email" type="email" class="form-control" placeholder="Username" name="email" value="{{ old('email') }}" required autofocus>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group d-flex align-items-center">
                                <div class="form-check mb-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="remember" id="remember" checked="{{ old('remember') ? 'checked' : '' }}" data-fouc class="form-input-styled">
                                        Remember
                                    </label>
                                </div>


                                @if (Route::has('password.request'))
                                    <a class="ml-auto" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /login card -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
@endsection
