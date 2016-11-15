<div class="col-md-10 chat-bx-message">
<div class="chat-message bg-white">
  @if(Auth::check())
  <input type="hidden" name="auth" value="{{ json_encode(Auth::user()) }}">
  @endif
    <input type="hidden" name="receiver" value="{{ Request::segment(2) }}" />
    <ul class="chat" id="chat">
      @if(count($messages) > 0)
         @foreach($messages as $message)
            @if(Auth::user()->id == $message->id)
                <li class="right clearfix">
                  <span class="chat-img pull-right">
                    <img src="/assets/img/user.png" alt="User Avatar">
                  </span>
                  <div class="chat-body clearfix">
                    <div class="header">
                      <strong class="primary-font">{{ $message->name }}</strong>
                      <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> {{ $message->created_at}}</small>
                    </div>
                    <p>{{ $message->message }}</p>
                  </div>
                </li>
               @else
                 <li class="left clearfix">
                   <span class="chat-img pull-left">
                     <img src="/assets/img/user.png" alt="User Avatar">
                   </span>
                   <div class="chat-body clearfix">
                     <div class="header">
                       <strong class="primary-font">{{ $message->name }}</strong>
                       <small class="pull-right text-muted"><i class="fa fa-clock-o"></i>{{ $message->created_at}}</small>
                     </div>
                     <p>{{ $message->message }}</p>
                   </div>
                 </li>
           @endif
         @endforeach
       @endif
    </ul>
</div>
<div class="chat-box bg-white">
	<div class="input-group">
		<input class="form-control border no-shadow no-rounded" name="message" id="message" placeholder="Type your message here">
		<span class="input-group-btn">
			<button class="btn btn-success no-rounded" type="button" id="chatbtn">Send</button>
		</span>
	</div><!-- /input-group -->
</div>
</div>
