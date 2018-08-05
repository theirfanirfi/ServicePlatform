<a class="dropdown-item"
   href="{{ route('invitation.action',
    [$notification->data['user']['id'], $notification->data['ship']['id'], $notification]) }}">
  {{ $notification->data['user']['name'] }}
  want to link you to a ship</a>