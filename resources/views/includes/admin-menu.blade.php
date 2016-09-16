@if(Request::segment(1) == "user" && Request::segment(2) !="" || Request::segment(1) == "usermanage")

  @if (Request::is('user/*') && Request::segment(3) =="" || Request::segment(1) == "usermanage")
  <a class="btn btn-sm" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add Folder
  </a>

  @if(Request::segment(1) != 'usermanage')
    <a class="btn btn-sm" href="/usermanage">
        <i class="fa fa-key"></i> User Permission
    </a>
  @endif

  <a class="btn btn-sm user-manage-permission" style="display:none;" href="javascript::void(0)">
      <i class="fa fa-key"></i> add Manage Permission
  </a>

  @endif

@endif
