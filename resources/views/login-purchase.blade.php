@extends('layouts.app')


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                
                @if ($message = Session::get('active'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ url('loginasuser') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="username" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <span style="border:1px solid #ddd;padding:0 2px; float: right;">
                                    <i id="eyeChangeId" class="fa fa-eye" onclick="eyeEnableOrDisable()"></i>
                                </span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //Javascript function definition
    function eyeEnableOrDisable() 
    {
      var x = document.getElementById("password"); //getting the password field element
      var y = document.getElementById("eyeChangeId"); //getting the eye button element
      if (x.type === "password") 
      {
        x.type = "text";
        y.classList.remove("fa-eye");
        y.classList.add("fa-eye-slash");
      } 
      else 
      {
        x.type = "password";
        y.classList.remove("fa-eye-slash");
        y.classList.add("fa-eye");
      }
    }
</script>
@endsection
