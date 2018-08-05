@extends('layouts.frontlayout')

@section ('frontcontent')
    <div class="container">
        <h1 class="ml-3">Linked Users</h1>
        @if(count($invitations) < 1)
            <p class="ml-3">No Linked Users</p>
        @endif
        <ul>
            @foreach($invitations as $invitation)
                <li class="mb-3">
                    <span class="mx-3">
                        {{ Form::model($invitation, array('route' => array('project.invitation.permissions', $id, $invitation->user_invited->id), 'class'=>'d-inline-block')) }}
                        <ul class="list-inline">
                            <li class="list-inline-item">{{ $invitation->user_invited->email }}</li>
                            @if($invitation->status === 1)
                                <li class="list-inline-item">Accepted</li>
                            @elseif($invitation->status === 2)
                                <li class="list-inline-item">Rejected</li>
                            @else
                                <li class="list-inline-item">Pending</li>
                            @endif
                            @if($project->canDelete())
                                <li class="list-inline-item">{{ Form::label('view_files') }} {{ Form::checkbox('view_files', 1) }}</li>
                                <li class="list-inline-item">{{ Form::label('upload_files') }} {{ Form::checkbox('upload_files', 1) }}</li>
                                <input type="submit" class="btn btn-primary btn-sm" value="Save">
                            @endif
                        </ul>
                        {{ Form::close() }}
                    </span>
                    @if($project->canDelete())
                    <span class="ml-1">
                        {{ Form::open(array('route' => array('project.invitation.destroy', $invitation->user_invited->id, $id), 'method' => 'delete', 'class'=>'d-inline-block')) }}
                            <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                        {{ Form::close() }}
                    </span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection