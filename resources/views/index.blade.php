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
    <h1>
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
    </h1>

    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        
    </div>

    <div class="row folders_area">

        @if (isset($folders) && count($folders) > 0)
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
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>

</section><!-- /.content -->

<!-- Modals -->

@include('modals.folder_add')
@include('modals.files_upload')

@stop
