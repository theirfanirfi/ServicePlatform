@extends('layouts.frontlayout')

@section('frontcontent')

  <!-- Page Content -->
  <div class="container">
    @if ($message = session()->get('success'))
      <div class="alert alert-success hi">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ $message }}</p>
      </div>
    @endif
    @if ($message = session()->get('error'))
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ $message }}</p></div>
    @endif


    {{--<div class="row">
      <div class="mt-4 col-xs-12">
        <div class="container">
          <h4>Notifications:
            @if(count(auth()->user()->unreadNotifications) < 1)
              No
              @else
              {{ count(auth()->user()->unreadNotifications) }}
              @endif
            Unread Notification/s.

          </h4>
        </div>
      </div>
    </div>--}}

    <div class="row">
      <div class="col-sm-12">
        <h2 class="mt-4">Edit Profile</h2>
        <form method="post" id="edit_profile" action="{{ route('dashboard.updateprofile', auth()->user()->id)}}"
              enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="form-control"
                     placeholder="Full Name" required>
            </div>
            @if ($errors->has('name'))
              <span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
				</span>
            @endif
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control"
                     placeholder="Email" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="text" name="contact" id="contact" value="{{ auth()->user()->contact }}" class="form-control"
                     placeholder="Contact Number">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="address">Address</label>
              <textarea name="address" class="form-control">{{ auth()->user()->address }}</textarea>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="profile">Profile</label>
              <input type="file" name="profile" class="form-control">
            </div>
            @if ($errors->has('profile'))
              <span class="help-block">
					<strong>{{ $errors->first('profile') }}</strong>
				</span>
            @endif
          </div>

          @if( auth()->user()->profile )
            <div class="col-md-6">
              <div class="form-group">
                <img src="{{ auth()->user()->profile }}" width="200" height="200">
              </div>
            </div>
          @endif

          <div class="col-md-12">
            {{csrf_field()}}
            <input type="hidden" name="prev_pass" value="{{ auth()->user()->password }}">
            <input type="hidden" name="prev_profile" value="{{ auth()->user()->profile }}">
            <input type="submit" name="update_profile" id="update_profile" value="Save" class="btn btn-success">
          </div>
        </form>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">

        <h2 class="mt-4">Ship Details</h2>
        <table class="table" id="ship-request-list-table">
            <thead>
              <tr>
                <th>Ship ID</th>
                <th>Ship Name</th>
                <th>Sender Name</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach($ships_request as  $key=>$value)
                  <tr>
                    <td>{{ $value->details->id }}</td>
                    <td>
                      @if($value->status == 1)
                        <a href="{{ route('view_ship',['ship_id'=>$value->details->id]) }}"> {{ $value->details->name }}</a>
                      @else
                        {{ $value->details->name }}
                      @endif
                    </td>
                    <td>{{ $value->userDetails->name }}</td>
                    <td>
                      @if($value->status == 0)
                        <lable class="label label-default">Pending</lable>
                      @elseif($value->status == 1)
                        <lable class="label label-success">Accepted</lable>
                      @elseif($value->status == 2)
                        <lable class="label label-danger">Rejected</lable>
                      @endif
                    </td>
                    <td>
                      @if($value->status == 0)
                        <div class="row">
                          {{ Form::open(array('url' => route('ship.request.accept',['ship_id'=>$value->id]), 'method' => 'POST')) }}
                          <input type="submit" name="ship_accept" value="Accept" class="btn btn-primary">
                          {{ Form::close() }}

                          {{ Form::open(array('url' => route('ship.request.reject',['ship_id'=>$value->id]), 'method' => 'POST')) }}
                          <input type="submit" name="ship_reject" value="Reject" class="btn btn-danger">
                          {{ Form::close() }}
                        </div>
                      @elseif($value->status == 1)
                        {{ Form::open(array('url' => route('ship.request.reject',['ship_id'=>$value->id]), 'method' => 'POST')) }}
                        <input type="submit" name="ship_reject" value="Reject" class="btn btn-danger">
                        {{ Form::close() }}
                      @elseif($value->status == 2)
                        <lable >Rejected</lable>
                      @endif
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <!-- /.row -->

  </div>
@endsection

@push('after_css')
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endpush

@push('after_scripts')
  <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script>
      $(document).ready( function () {
          $('#ship-request-list-table').DataTable();
      } );
  </script>
@endpush