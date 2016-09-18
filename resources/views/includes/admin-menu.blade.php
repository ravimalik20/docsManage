@if(Request::segment(1) == "user" && Request::segment(2) !="" || Request::segment(1) == "usermanage")

    {{--*/
        $this_user = \App\User::find(Request::segment(2));
    /*--}}

  @if (Request::is('user/*') && Request::segment(3) =="" || Request::segment(1) == "usermanage")
  <a class="btn btn-sm fileAddModalclick" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add Folder
  </a>

  @if(Request::segment(1) != 'usermanage' && $this_user->role != "admin")
    <a class="btn btn-sm" href="/usermanage">
        <i class="fa fa-key"></i> User Permission
    </a>
  @endif



  @endif

@endif
