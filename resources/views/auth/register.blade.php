@extends('layouts.frontlayout')

@section('frontcontent')
<div class="container">
    <div class="row">
		<div class="col-sm-12">
          <h2 class="mt-4">Register</h2>
		  <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

						<div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						
                        <div class="col-md-6">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="col-md-6">
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

                       <div class="col-md-6">
						<div class="form-group">
                            <label for="password-confirm" class="control-label">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
						
					      <div class="col-md-6">
						  <div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                            <label for="user_type" class="control-label">Select User Type</label>
                                <select name="user_type" id="user_type" class="form-control" required>
								<option value="">User Type</option>
								<option value="3">Buyer</option>
								<option value="4">Seller</option>
								</select>
                            </div>
							@if ($errors->has('user_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_type') }}</strong>
                                    </span>
                            @endif
                        </div>
						
						<div class="col-md-6">
                        <div class="form-group">
						<label for="user_type" class="control-label"></label>
                                <button type="submit" class="btn btn-primary form-control">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
		</div>
    </div>
</div>
@endsection
