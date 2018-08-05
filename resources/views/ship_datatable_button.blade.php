{{ Form::model($model, ['route' => ['deleteShip', $model->id], 'method' => 'DELETE']) }}

<a href="{{URL::to('/ship/schedules')}}/{{$model->id}}" class="btn btn-sm btn-primary" title="Schedules">Schedules</a>
	<a href="{{ route('formShip', $model->id) }}" class="btn btn-sm btn-success" title="Edit">Edit</a>

    {{--<a href="{{ route('formShip', $model->id) }}" class="btn btn-sm btn-success" title="Edit">Edit</a>--}}
    <a href="{{ route('invitation.edit', $model->id) }}" class="btn btn-sm btn-info" title="Edit">View Invited</a>
{{--{{ dd($model->shareUserAcceptname) }}--}}
    <a href="{{ route('share_ship.edit',$model->id) }}" class="btn btn-sm btn-success" title="Share">Share</a>

    <input type="submit" class="btn btn-sm btn-danger" value="Delete">
	
{{ Form::close() }}
