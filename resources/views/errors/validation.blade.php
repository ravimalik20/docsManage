@if ( $errors->count() > 0 )
	@if ( $errors->count() > 1 )<p>Following errors have occurred:</p>@endif
	  <ul>
		@foreach( $errors->all() as $message )
		  <li style="color:#D13736;">{{ $message }}</li>
		@endforeach
	  </ul>
@endif
