@extends('layouts.frontlayout')
@php
    $vessels = [
        1 => "Aggregates Carrier",
        2 => "Anchor Handling Vessel",
        3 => "Asphalt/Bitumen Tanker",
        4 => "Bulk Carrier",
        5 => "Bunkering Tanker",
        6 => "Cable Layer",
        8 => "Cement Carrier",
        9 => "Chemical Tanker",
        10 => "Container Ship",
        11 => "Crew Boat",
        12 => "Crude Oil Tanker",
        13 => "Dredger",
        14 => "Drill Ship",
        15 => "Fire Fighting Vessel",
        16 => "Fish Carrier",
        18 => "Fishing Vessel",
        19 => "Floating Crane",
        20 => "Floating Storage/Production",
        21 => "General Cargo",
        22 => "Heavy Load Carrier",
        23 => "High Speed Craft",
        24 => "Icebreaker",
        25 => "Inland Passenger Ship",
        26 => "Landing Craft",
        27 => "Livestock Carrier",
        28 => "LNG Tanker",
        29 => "LPG Tanker",
        30 => "Military Ops",
        31 => "Navigation Aids",
        32 => "OBO Carrier",
        33 => "Offshore Structure",
        34 => "Offshore Vessel",
        35 => "Oil Products Tanker",
        36 => "Oil/Chemical Tanker",
        37 => "Ore Carrier",
        38 => "Special Craft",
        39 => "Special Cargo",
        40 => "Special Fishing Vessel",
        41 => "Special Passenger Vessel",
        42 => "Other Pleasure Craft",
        43 => "Special Tanker",
        45 => "Passenger/Cargo Ship",
        46 => "Passenger Ship",
        47 => "Patrol Vessel",
        48 => "Pilot Boat",
        49 => "Platform",
        50 => "Pollution Control Vessel",
        51 => "Pusher Tug",
        52 => "Reefer",
        53 => "Research/Survey Vessel",
        54 => "Ro-Ro/Passenger Ship",
        55 => "Ro-Ro/Vehicles Carrier",
        56 => "Sailing Vessel",
        57 => "Search & Rescue",
        58 => "Service Vessel",
        59 => "Special Tug",
        60 => "Supply Vessel",
        61 => "Tanker",
        62 => "Training Ship",
        63 => "Trawler",
        64 => "Tug",
        65 => "Tug/Supply Vessel",
        66 => "Water Tanker",
        67 => "Yacht",
        68 => "Barge",
        69 => "Inland Tanker",
        70 => "Inland Cargo",
        71 => "Inland Tug",
        900 => "Unspecified",
        902 => "Other Fishing",
        903 => "Other Tug / Special Craft",
        904 => "High Speed Craft",
        906 => "Other Passenger Ship",
        907 => "Other Cargo",
        908 => "Other Tanker",
    ];
@endphp
@section('frontcontent')

  <!-- Page Content -->
  <div class="container">
    @if ($message = session()->get('success'))
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ $message }}</p>
      </div>
    @endif
    @if ($message = session()->get('error'))
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ $message }}</p></div>
    @endif

    <div class="row">
      <div class="col-sm-12">
        <h2 class="mt-4">Ship</h2>
        {!! Form::model($ship, ['route' => ['storeShip']]) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('imo', 'IMO') !!}
              {!! Form::text('imo', null, ['class' => 'form-control']) !!}
              @if ($errors->has('imo'))
                <span class="help-block">
                  <strong>{{ $errors->first('imo') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('name') !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('MMSI') !!}
              {!! Form::text('mmsi', null, ['class' => 'form-control']) !!}
              @if ($errors->has('mmsi'))
                <span class="help-block">
                  <strong>{{ $errors->first('mmsi') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('vessel') !!}
              {!! Form::select('vessel', $vessels, null, ['class' => 'form-control', 'id' => 'vessel']) !!}
              @if ($errors->has('vessel'))
                <span class="help-block">
                  <strong>{{ $errors->first('vessel') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('gross_tonnage') !!}
              {!! Form::number('gross_tonnage', null, ['class' => 'form-control']) !!}
              @if ($errors->has('gross_tonnage'))
                <span class="help-block">
                  <strong>{{ $errors->first('gross_tonnage') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('build') !!}
              {!! Form::number('build', null, ['class' => 'form-control']) !!}
              @if ($errors->has('build'))
                <span class="help-block">
                  <strong>{{ $errors->first('build') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('flag') !!}
              {!! Form::select('flag', Countries::getList('en', 'php'), null, ['class' => 'form-control', 'id' => 'country']) !!}
              @if ($errors->has('flag'))
                <span class="help-block">
                  <strong>{{ $errors->first('flag') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('home_port') !!}
              {!! Form::text('home_port', null, ['class' => 'form-control']) !!}
              @if ($errors->has('home_port'))
                <span class="help-block">
                  <strong>{{ $errors->first('home_port') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="col-12">
            @if(isset($sellers))

              <h4>Invite Seller</h4>
              <div class="form-group clearfix">
                @foreach($sellers as $seller)
                  <div class="d-inline w-25 float-left">
                    <label class="form-check-label d-block ml-3">
                      <input type="checkbox" class="form-check-input" name="seller[]"
                             value="{{ $seller->id }}"> {{ $seller->email }}
                    </label>
                  </div>
                @endforeach

                @if ($errors->has('invite_seller'))
                  <span class="help-block">
                    <strong>{{ $errors->first('invite_seller') }}</strong>
                  </span>
                @endif
              </div>
            @endif

            @if(isset($buyers))
                <h4>Invite Buyer</h4>
                <div class="form-group clearfix">
                  @foreach($buyers as $buyer)
                    <div class="d-inline w-25 float-left">
                      <label class="form-check-label d-block ml-3">
                        <input type="checkbox" class="form-check-input" name="seller[]"
                               value="{{ $buyer->id }}"> {{ $buyer->email }}
                      </label>
                    </div>
                  @endforeach

                  @if ($errors->has('invite_seller'))
                    <span class="help-block">
                      <strong>{{ $errors->first('invite_seller') }}</strong>
                    </span>
                  @endif
                </div>

            @endif

          </div>

        </div>
        <div class="row">
          <div class="mt-4 col-md-12 text-center">
            <a class="btn btn-default" href="{{ route('ships') }}">back</a>
            {!! Form::submit('Send', ['class' => 'btn btn-primary col-md-2']) !!}
          </div>
        </div>
        <br><br>
        {!! Form::hidden('ship_id', $ship->id) !!}
        {!! Form::close() !!}
      </div>

    </div>
    <!-- /.row -->

  </div>
@endsection
@push('after_scripts')
  <script>
      $(document).ready(function () {
          $('#country').select2();
          $('#vessel').select2();
      });
  </script>
@endpush