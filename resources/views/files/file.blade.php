@extends('layouts.admin')

@section('extra_scripts')

<script src="/assets/js/file.js"></script>

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if (isset($pathStr))
            {{$pathStr}}{{$file->name}}
        @else
        /{{$file->name}}
        @endif
    </h1>
    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <a class="btn btn-default col-sm-2 print_file" href="#"><i class="fa fa-print"></i> Print</a>
        <a class="btn btn-default col-sm-2 download_file"
            href="/folder/{{$folder_id}}/file/{{$file->id}}/download"><i class="fa fa-download"></i> Download</a>
        <form action="/folder/{{$folder_id}}/file/{{$file->id}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE"/>
            <button class="btn btn-default col-sm-2" type="submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
    </div>

    <iframe class="file_content_area" id="file_content" name="file_content"
        src="/folder/{{$folder_id}}/file/{{$file->id}}/content">
    </iframe>

</section>

@stop
