<div class="col-md-12 bg-white ">
  <div class=" row border-bottom padding-sm" style="height: 40px;">
  	Member
  </div>

  <!-- =============================================================== -->
  <!-- member list -->
  <ul class="friend-list">
      @if(count($user_messages) > 0)
        @foreach($user_messages as $user_message)
        <li class="active bounceInDown">
          {{--*/
                if($user_message->receiver_id == Auth::user()->id) {
                    $user_message->receiver_id = $user_message->sender_id;
                }
            /*--}}
        	<a href="/message/{{ $user_message->receiver_id }}" class="clearfix">
        		<img src="/assets/img/user.png" alt="" class="img-circle">
        		<div class="friend-name">
        			<strong>{{ $user_message->name }}</strong>
        		</div>
        		<div class="last-message text-muted">{{ $user_message->message }}</div>
        		<small class="time text-muted">{{ $user_message->created_at }}</small>
            @if($user_message->status != 'read')
        		  <small class="chat-alert label label-danger">1</small>
            @endif
        	</a>
        </li>
      @endforeach
      @endif
  </ul>
</div>
