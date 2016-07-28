<a class="btn btn-sm" href="/user">
    <i class="fa fa-users"></i> users
</a>
@if(Request::segment(1) == "user" && Request::segment(2) !="")
<a class="btn btn-sm" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
    <i class="fa fa-file"></i> Add File
</a>
@if(Request::segment(3) == "history")
  <a class="btn btn-sm" href="/user">
      <i class="fa fa-history"></i> User Logs
  </a>
@else
  <a class="btn btn-sm" href="/user/{{ Request::segment(2) }}/history">
      <i class="fa fa-history"></i> User Logs
  </a>
@endif
@endif
