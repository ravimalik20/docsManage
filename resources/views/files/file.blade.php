@extends('layouts.admin')

@section('extra_scripts')

<script src="/assets/js/file.js"></script>

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <a class="btn btn-default col-sm-2 print_file" href="#"><i class="fa fa-print"></i> Print</a>
        <a class="btn btn-default col-sm-2 download_file"
            href="/folder/{{$folder_id}}/file/{{$file->id}}/download"><i class="fa fa-download"></i> Download</a>
    </div>

    <iframe class="file_content_area" id="file_content" name="file_content"
        src="/folder/{{$folder_id}}/file/{{$file->id}}/content">
    </iframe>

</section>

@stop
