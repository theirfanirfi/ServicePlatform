{{ Form::model($model, ['route' => ['project.form.delete', $model->id], 'method' => 'DELETE']) }}
@if($model->canDelete())
    <a href="{{ route('form.project', $model->id) }}" class="btn btn-sm btn-success" title="Edit">Edit</a>
@endif
@if($model->canUploadFiles())
    <a href="{{ route('form.project', $model->id) }}" class="btn btn-sm btn-success" title="Attach files">Attach files</a>
@endif
    <a href="{{ route('project.view', $model->id) }}" class="btn btn-sm btn-primary" title="Edit">view</a>
@if($model->canInvite())
    <a href="{{ route('project.invitation.edit', $model->id) }}" class="btn btn-sm btn-info" title="Edit">View Invited</a>
    <a href="{{ route('share.edit', $model->id) }}" class="btn btn-sm btn-success" title="Share">Share</a>
@endif
@if($model->canDelete())
    <input type="submit" class="btn btn-sm btn-danger" value="Delete">
@endif
{{ Form::close() }}
