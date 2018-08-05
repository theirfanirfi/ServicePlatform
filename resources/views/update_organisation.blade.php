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
                <h2 class="mt-4">Update organisation</h2>
                {{ Form::open(array('url' => route('organisation.update',['organisation'=>$contacts->id]), 'method' => 'PUT', 'class'=>'col-md-12')) }}

                {{--<form method="put" action="{{ route('contacts.update',['contact'=>$contacts->id]) }}">--}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ $contacts->name }}" class="form-control" placeholder="Name" required>
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
                            <input type="number" name="vat_number" id="vat_number" value="{{ $contacts->vat_number }}" class="form-control" placeholder="Vat Number" required>
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
                            <input type="number" name="phone" id="phone" value="{{ $contacts->phone }}" class="form-control" placeholder="Phone" required>
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
                            <textarea name="address" id="address" class="form-control">{{ $contacts->address }}</textarea>
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
                            <input type="text" name="city" id="city" value="{{ $contacts->city }}" class="form-control" required>
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
                            <input type="text" name="country" id="country" class="form-control" value="{{ $contacts->country }}" required>
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
                            <input type="number" name="zip_code" id="zip_code" value="{{ $contacts->zip_code }}" class="form-control" required>
                        </div>
                        @if ($errors->has('zip_code'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('zip_code') }}</strong>
                                </span>
                        @endif
                    </div>

                <div class="col-md-12">
                    {{csrf_field()}}
                    <input type="submit" name="edit_organisation" id="edit_organisation" value="Update Organisation" class="btn btn-success">
                </div>
                {{--</form>--}}
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection