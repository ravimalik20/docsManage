@extends('layouts.admin')

@section('extra_scripts')

<script src="/assets/js/index.js"></script>

<script src="/assets/js/main.js"></script>

@stop

@section('content')

<div id="info_div" style="display:none;"
@if (Request::segment(1) == "user" && Request::segment(3) == "folder" && Request::segment(4) != "")
    data-folder-id="{{ Request::segment(4) }}"
@endif
></div>

<!-- Content Header (Page header) -->
<section class="content-header">
        <div class="menu">
          @if(Auth::check() && Auth::user()->role !="admin")
            @if (isset($pathStr))
                {{$pathStr}}
            @else
            /
            @endif

            <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
                <i class="fa fa-folder"></i> Add Folder
            </a>
            <a class="btn btn-sm" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
                <i class="fa fa-file"></i> Add File
            </a>
            <a class="btn btn-sm delete_file_folder" data-token="{{csrf_token()}}"><i class="fa fa-trash"></i> Delete</a>
            <a class="btn btn-sm" href="/sharedfolder" data-token="{{csrf_token()}}"><i class="fa fa-folder"></i> Shared Document</a>
            <a class="btn btn-sm" href="/setting"><i class="fa fa-wrench"></i>Settings</a>
            @endif
            @if(Auth::check() && Auth::user()->role == 'admin')
                @include("includes.admin-menu")
            @endif
        </div>
    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">
    @if(Session::has("message"))
      <div class="alert alert-dismissable {{ Session::get("message")["type"] }}">
          <i class="fa {{ Session::get("message")["icon"] }}"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          @if( count(Session::get("message")["data"]) )
            @foreach(Session::get("message")["data"] as $msg)
              <p> {{ $msg }}</p>
            @endforeach
          @endif
      </div>
    @endif

    @if( $page == 'userlist' )
      @include("user.list")
    @elseif( $page == 'userdocuments' )
      @include("user.documents")
    @elseif( $page == 'user_history' )
      @include("user.history")
    @elseif( $page == 'setting' )
      @include("user.setting")
    @endif
</section><!-- /.content -->

<!-- Modals -->

@include('modals.folder_add')
@include('modals.files_upload')
@include('modals.permission-add-modal')

@stop
