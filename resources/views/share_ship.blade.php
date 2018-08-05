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
                <h2 class="mt-4">Share Ships</h2>

                {{ Form::open(array('url' => route('share_ship.update',['share_ship'=>$ship_id]), 'method' => 'PUT', 'class'=>'col-md-12')) }}

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_id">Select User </label>
                        <select class="form-control" name="user_id" id="user_id" required>
                            @foreach($userList as $key=>$value)
                                @if($value->id != Auth::user()->id)
                                    @if(!in_array($value->id,$already_share))
                                        <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                    @endif
                                @endif

                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('user_id'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                    @endif
                </div>

                <div class="col-md-6">
                    {{csrf_field()}}
                    <input type="submit" name="share_ship" id="share_ship" value="Share" class="btn btn-success">
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script>
        $(document).ready(function () {
            $('#user_id').select2();
        });
    </script>
@endpush