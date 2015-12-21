@extends('layouts.admin')

@section('extra_scripts')

<!-- Ace editor for web -->
<script src="/assets/ace/ace.js"></script>
<script src="/assets/ace/ext-language_tools.js"></script>

<script src="/assets/js/file.js"></script>

<style type="text/css" media="screen">
    #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;

        height:480px;
    }
</style>

<script src="/assets/js/file_edit.js"></script>

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
        <a class="btn btn-default col-sm-2 edit_file" href="#"><i class="fa fa-save"></i> Save</a>
        <a class="btn btn-default col-sm-2 download_file"
            href="/folder/{{$folder_id}}/file/{{$file->id}}/download"><i class="fa fa-download"></i> Download</a>
        <form action="/folder/{{$folder_id}}/file/{{$file->id}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE"/>
            
            <button class="btn btn-default col-sm-2" type="submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form action="/folder/{{$folder_id}}/file/{{$file->id}}" method="POST" id="editor_form">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="content" value="">
                <pre id="editor" data-language="{{$file->language()}}">{{$content}}</pre>
            </form>
        </div>
    </div>

</section>

@stop
