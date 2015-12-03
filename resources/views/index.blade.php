@extends('layouts.admin')

@section('extra_scripts')

<script src="/assets/js/index.js"></script>

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        /
        <small>Root Directory</small>

        <a class="btn btn-sm" href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
            <i class="fa fa-folder"></i> Add Folder
        </a>
        <a class="btn btn-sm"><i class="fa fa-file"></i> Add File</a>
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
        <div class="folder col-lg-2 col-sm-2 col-xs-3 text-center">
            <div class="file_icon">
                <a href="#"><i class="fa fa-folder fa-5x"></i></a>
            </div>
            <div class="file_name">
                <span>{{$folder->name}}</span>
            </div>
        </div>
        @endforeach
        @endif

        @for ($i=0 ; $i<5 ; $i++)
        <div class="file col-lg-2 col-sm-2 col-xs-3 text-center">
            <div class="file_icon">
                <a href="#"><i class="fa fa-file fa-5x"></i></a>
            </div>
            <div class="file_name">
                <span>FileName.txt</span>
            </div>
        </div>
        @endfor

    </div>

</section><!-- /.content -->

<!-- Modals -->

@include('modals.folder_add')

@stop
