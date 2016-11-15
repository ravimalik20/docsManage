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
    @include('includes.sub-menu')
</section>

<!-- Main content -->
<section class="content">
    @include('errors.validation')
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
      @include("user.home")
    @elseif( $page == 'userdocuments' )
      @include("user.documents")
    @elseif( $page == 'user_history' )
      @include("user.history")
	  @elseif( $page == 'user_home' )
      @include("user.home")
    @elseif( $page == 'setting' )
      @include("user.setting")
    @elseif( $page == 'usermanage' )
      @include("user.usermanage")

    @elseif( $page == 'userfilerequest' )
      @include("user.userfilerequest")

    @endif
</section><!-- /.content -->

<!-- Modals -->

@include('modals.folder_add')
@include('modals.files_upload')
@include('modals.permission-add-modal')
@include('modals.filenewrequest')
@include('modals.file-requests')
@include('modals.manage-user-permissions-modal')
@include('modals.payment_checkout')

@stop
