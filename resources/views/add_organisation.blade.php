@extends('layouts.frontlayout')

@section('frontcontent')
    <!-- Page Content -->
    <div class="container">

        @if (session()->has('message'))
            <div class="alert alert-success hi">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ session()->get('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger hi">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ session()->get('error') }}</p>
            </div>
        @endif

        @if(isset($errors))
            @foreach($errors->all() as $error)
                <div class="alert alert-danger hi">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>{{ $error }}</p></div>
            @endforeach
        @endif

        <div class="row">
            <div class="col-sm-12">
                <h2 class="mt-4">Add Organisation</h2>
                <form method="post" action="{{ route('organisation.store') }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Organisation Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Organisation Name" required>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vat_number">Vat Number </label>
                            <input type="number" name="vat_number" id="vat_number" value="{{ old('vat_number') }}" class="form-control" placeholder="Vat Number" required>
                        </div>
                        @if ($errors->has('vat_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('vat_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone </label>
                            <input type="number" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" placeholder="Phone" required>
                        </div>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address </label>
                            <textarea name="address" id="address" placeholder="Address" class="form-control">{{ old('address') }}</textarea>
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City </label>
                            <input type="text" placeholder="City" name="city" id="city" value="{{ old('city') }}" class="form-control" required>
                        </div>
                        @if ($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country </label>
                            <input type="text" placeholder="Country" name="country" id="country" class="form-control" value="{{ old('country') }}" required>
                        </div>
                        @if ($errors->has('country'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zip_code">Zip Code </label>
                            <input type="number" placeholder="Zip Code" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" class="form-control" required>
                        </div>
                        @if ($errors->has('zip_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('zip_code') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12">
                        {{csrf_field()}}
                        <input type="submit" name="add_organisation" id="add_organisation" value="Add New Organisation" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection