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
                <h2 class="mt-4">Add Contact</h2>
                <form method="post" action="{{ route('contacts.store') }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" id="surname" value="{{ old('surname') }}" class="form-control" placeholder="Surname" required>
                        </div>
                        @if ($errors->has('surname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('surname') }}</strong>
                            </span>
                        @endif
                    </div>
                  {{-- <div class="col-md-6">--}}
                      {{--  <div class="form-group"> --}}
                          {{--  <label for="company">Company Name</label> --}}
                           {{-- <input type="text" name="company" id="company" value="" class="form-control" placeholder="Company Name" required> --}}
                       {{-- </div> --}}
                       {{-- @if ($errors->has('company')) --}}
                           {{-- <span class="help-block"> --}}
                               {{-- <strong>{{ $errors->first('company') }}</strong> --}}
                           {{-- </span> --}}
                       {{-- @endif --}}
                   {{-- </div> --}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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
                            <textarea name="address" id="address" class="form-control"> {{ old('address') }} </textarea>
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">Contact </label>
                            <select class="form-control" name="contact" id="contact">
                                <option value="Agent">Agent</option>
                                <option value="Forwarder">Forwarder</option>
                            </select>
                        </div>
                        @if ($errors->has('contact'))
                            <span class="help-block">
                                <strong>{{ $errors->first('contact') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organisation_id">Select Organisation </label>
                            <select class="form-control" name="organisation_id" id="organisation_id">
                                @foreach($organisationList as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('organisation_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('organisation_id') }}</strong>
                            </span>
                        @endif
                    </div>



                    <div class="col-md-12">
                        {{csrf_field()}}
                        <input type="submit" name="add_contact" id="add_contact" value="Add New Contact" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('after_scripts')
    <script>
        $(document).ready(function () {
            $('#organisation_id').select2();
        });
    </script>
@endpush