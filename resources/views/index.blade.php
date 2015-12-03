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
        @if (isset($folder))
            /{{$folder->name}}
        @else
        /
        <small>Root Directory</small>
        @endif

        <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
            <i class="fa fa-folder"></i> Add Folder
        </a>
        <a class="btn btn-sm"><i class="fa fa-file"></i> Add File</a>
        <a class="btn btn-sm delete_file_folder" data-token="{{csrf_token()}}"><i class="fa fa-trash"></i> Delete</a>
    </h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> /</a></li>
        <li class="active">Folder 1</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        
    </div>

    <div class="row folders_area">

        @if (isset($folders) && count($folders) > 0)
        @foreach ($folders as $folder)
        <div class="folder col-lg-2 col-sm-2 col-xs-3">
            <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="folders" value="{{$folder->id}}" autocomplete="off">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon text-center">
                        <a href="/folder/{{$folder->id}}"><i class="fa fa-folder fa-5x"></i></a>
                    </div>
                    <div class="file_name text-center">
                        <span>{{$folder->name}}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        {{--@for ($i=0 ; $i<5 ; $i++)
        <div class="file col-lg-2 col-sm-2 col-xs-3 text-center">
            <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="folders" autocomplete="off">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon">
                        <a href="#"><i class="fa fa-file fa-5x"></i></a>
                    </div>
                    <div class="file_name">
                        <span>FileName.txt</span>
                    </div>
                </div>
            </div>
        </div>
        @endfor--}}

    </div>

</section><!-- /.content -->

<!-- Modals -->

@include('modals.folder_add')

@stop
