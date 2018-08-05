@extends('layouts.frontlayout')

@section ('frontcontent')
  <div class="container">
    <h3 class="mt-5">Inviter:</h3>
    <ul>
      <li>Name: {{ $user->name }}</li>
      <li>Email: {{ $user->email }}</li>
    </ul>
    <h3 class="mt-5">Ship:</h3>
    <ul>
      <li>Name: {{ $ship->name }}</li>
      <li>IMO: {{ $ship->imo }}</li>
      <li>MMSI: {{ $ship->mmsi }}</li>
      <li>Build: {{ $ship->build }}</li>
    </ul>

    <h3 class="mt-3">Action</h3>
    <div class="mb-5">
      {{ Form::open(array('route' => array('invitation.decision', 1, $user, $ship, $notification), 'method' => 'post', 'class'=>'d-inline-block')) }}
      <input type="submit" class="btn btn-success" value="Accept">
      {{ Form::close() }}
      {{ Form::open(array('route' => array('invitation.decision', 2, $user, $ship, $notification), 'method' => 'post', 'class'=>'d-inline-block ml-5')) }}
      <input type="submit" class="btn btn-danger" value="Reject">
      {{ Form::close() }}
    </div>
  </div>
@endsection