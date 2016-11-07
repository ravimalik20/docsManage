<!-- {{--*/
        $this_user = \App\User::find(Request::segment(2));
    /*--}}

 @if (Request::is('user/*') && Request::segment(3) =="" || Request::segment(1) == "usermanage")
@if(Request::segment(1) == "user" && Request::segment(2) !="" || Request::segment(1) == "usermanage")

 @if(isset($this_user) && $this_user->role == "admin")  
<a class="btn btn-sm fileAddModalclick" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add a File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add a Folder
  </a>
              
  @endif
                  
 
		@if(isset($this_user) && $this_user->role == "admin")
					@if (Session::has("selected_user"))
                     <a class="btn btn-sm fileAddModalclick" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add a File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add a Folder
  </a>      
					<a class="btn btn-sm " href="#filerequestmodal" data-toggle="modal" data-target="#filerequestmodal">
					<i class="fa fa-list"></i> File Requests
					</a> 

					@endif 
					
					
			@endif 
 			
		@endif

  @if(isset($this_user) && $this_user->role != "admin")
				
                           
					<a class="btn btn-sm " href="#filerequestmodal" data-toggle="modal" data-target="#filerequestmodal">
					<i class="fa fa-eye"></i> View File Requests
					</a> 

					@endif 
  
  



  @endif

-->
    
    @if( $page == 'userdocuments' )
		<a class="btn btn-sm fileAddModalclick" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add a File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add a Folder
  </a> 
      
    @elseif( $page == 'user_history' )
   
	  @elseif( $page == 'user_home' )
  
    @elseif( $page == 'setting' )
   
    @elseif( $page == 'usermanage' )
  
	  
    @endif
