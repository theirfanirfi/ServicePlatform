<a class="dropdown-item"
   href="{{ route('project.invitation.action',
    [$notification->data['user']['id'], $notification->data['project']['id'], $notification]) }}">
  {{ $notification->data['user']['name'] }}
  want to link you to a project</a>