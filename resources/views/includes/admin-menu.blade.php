@if(Request::segment(1) == "user" && Request::segment(2) !="")

  @if (Request::is('user/*') && Request::segment(3) =="")
  <a class="btn btn-sm" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
      <i class="fa fa-file"></i> Add File
  </a>
  <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
      <i class="fa fa-folder"></i> Add Folder
  </a>
  @endif

@endif
