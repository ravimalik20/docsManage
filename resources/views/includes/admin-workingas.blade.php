<!-- For All Pages -->

{{--*/
	$non_admin_users = \App\User::nonAdminUsers();
/*--}}

<!--For Files PAge -->
    @if( $page == 'userdocuments' )
			@if (count($non_admin_users) > 0)
		    @foreach($non_admin_users as $user)
		    @if (\Session::has("selected_user") && \Session::get("selected_user") == $user->id)
		          <span style="color: #3c8dbc;vertical-align:middle;font-size:12px;"> <i class="fa fa-user"></i> Working As: {{$user->name}}</span>
		        @endif
		    @endforeach
	    @endif
			@if(Auth::check() && Auth::user()->role  == 'admin')
				 <a class="btn btn-sm fileAddModalclick" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
			      <i class="fa fa-file"></i> Add a File
			  </a>
			  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
			      <i class="fa fa-folder"></i> Add a Folder
			  </a>
				<a class="btn btn-sm " href="#filerequestmodal" data-toggle="modal" data-target="#filerequestmodal">
						<i class="fa fa-list"></i> File Requests
				</a>
				<a class="btn btn-sm " href="#changeAccountPermissionsModal" data-toggle="modal" data-target="#changeAccountPermissionsModal">
						<i class="fa fa-key"></i>Manage Account Permissions
				</a>
			@endif
	  @endif

<!-- For History Page -->
   @if( $page == 'user_history' )
	   <p>user history</p>
   @endif

<!-- For Home Page -->
	  @if( $page == 'user_home' )
  <p>user Home</p>
   @endif
   @if( $page == 'setting' )
     @endif
    @if( $page == 'usermanage' )
     @endif
