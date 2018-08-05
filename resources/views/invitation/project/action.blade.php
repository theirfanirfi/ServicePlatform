@extends('layouts.frontlayout')

@section ('frontcontent')
    <div class="container">
        <h3 class="mt-5">Inviter:</h3>
        <ul>
            <li>Name: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
        </ul>
        <h3 class="mt-5">Project:</h3>
        <ul>
            <li>Name: {{ $project->name }}</li>
            <li>Port: {{ $project->port }}</li>
            <li>Date: {{ $project->date }}</li>
            <li>Eta: {{ $project->eta }}</li>
            <li>Etb: {{ $project->etb }}</li>
            <li>Etd: {{ $project->etd }}</li>
        </ul>

        <h3 class="mt-3">Action</h3>
        <div class="mb-5">
            {{ Form::open(array('route' => array('project.invitation.decision', 1, $user, $project, $notification), 'method' => 'post', 'class'=>'d-inline-block')) }}
            <input type="submit" class="btn btn-success" value="Accept">
            {{ Form::close() }}
            {{ Form::open(array('route' => array('project.invitation.decision', 2, $user, $project, $notification), 'method' => 'post', 'class'=>'d-inline-block ml-5')) }}
            <input type="submit" class="btn btn-danger" value="Reject">
            {{ Form::close() }}
        </div>
    </div>
@endsection