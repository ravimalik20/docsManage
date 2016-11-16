

  @extends('layouts.admin')




@section('extra_scripts')

<script src="/assets/js/index.js"></script>

@stop

@section('content')

<div id="info_div" style="display:none;"
@if (isset($folder))
    data-folder-id="{{$folder->id}}"
@endif
></div>

<!-- Content Header (Page header) -->
<section class="content-header">
    @include('includes.sub-menu')
</section>

<!-- Main content -->
<section class="content">
  @include('errors.validation')
    <div class="row folders_area" style="display:block;">

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

        <!-- @if (isset($folders) && count($folders) > 0)

        @foreach ($folders as $f)
           <div class="folder col-lg-2 col-sm-2 col-xs-3">

                <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="folders" value="{{$f->id}}" autocomplete="off">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon text-center">
                       <a href="/folder/{{$f->id}}"><i class="fa fa-folder fa-5x"></i></a>

                   </div>
                    <div class="file_name text-center">
                        <span>{{$f->name}}</span>
                    </div>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                    <div class="permissionbtn">
                      <a class="btn btn-sm menu-middle-permission add_permision_btn" data-type="folder" data-id="{{$f->id}}" href="javascript:void(0)">
                          <i class="fa fa-key"></i> Add Permission
                      </a>
                    </div>
                    @endif
               </div>
            </div>
        </div>

        @endforeach

        @endif

        @if (isset($files) && count($files) > 0)
        @foreach ($files as $fs)
        <div class="file col-lg-2 col-sm-2 col-xs-3 text-center">
            <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="files" autocomplete="off" value="{{$fs->id}}">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon">
                        <a
                        @if (isset($folder))
                            href="/folder/{{$folder->id}}/file/{{$fs->id}}"
                        @else
                            href="/folder/0/file/{{$fs->id}}"
                        @endif
                        ><i class="fa fa-file fa-5x"></i></a>
                    </div>
                    <div class="file_name">
                        <span>{{$fs->name}}</span>
                    </div>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                    <div class="permissionbtn">
                      <a class="btn btn-sm menu-middle-permission add_permision_btn" data-type="file" data-id="{{$fs->id}}" href="javascript:void(0)">
                          <i class="fa fa-key"></i> add permission
                      </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>
-->
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
    @elseif( $page == 'payment' )
      @include("user.payment")

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
