
    
    @if( $page == 'userdocuments' )
      @include("user.documents")
    @elseif( $page == 'user_history' )
      @include("user.history")
	  @elseif( $page == 'user_home' )
      @include("user.home")
    @elseif( $page == 'setting' )
      @include("user.setting")
    @elseif( $page == 'usermanage' )
      @include("user.usermanage")
	  
    @endif