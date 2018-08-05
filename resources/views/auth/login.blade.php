@extends('layouts.frontlayout')

@section('frontcontent')
<div class="container">
    <div class="row">
       <div class="col-sm-12">
          <h2 class="mt-4">Login</h2>
		  
		  <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

						<div class="col-md-12">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="col-md-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="col-md-12">
                        <div class="form-group">
                            
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

						 <div class="col-md-12">
                        <div class="form-group">
                           
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <!--<a class="btn btn-link" href="">
                                    Forgot Your Password?
                                </a>-->
                            </div>
                        </div>
                    </form>
                </div>
	   </div>
    </div>
</div>
@endsection
