<div class="container">
  <h1 class="ml-3">Linked Users</h1>
  @if(count($users) < 1)
    <p class="ml-3">No Linked Users</p>
  @endif
  <ul>
    @foreach($users as $user)
      <li class="mb-3">{{ $user->email }}
        <span class="mx-3">
        @if($user->invited->status == 1)
            Accepted
          @elseif($user->invited->status == 2)
            Rejected
          @else
            Pending
          @endif
        </span>
        <span class="ml-1">
        {{ Form::open(array('route' => array('invitation.destroy', $user->invited->user_id, $ship->id), 'method' => 'delete', 'class'=>'d-inline-block')) }}
          <input type="submit" class="btn btn-danger" value="Remove">
          {{ Form::close() }}
      </span></li>
    @endforeach
  </ul>
</div>