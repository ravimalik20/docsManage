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
    <div class="row">
        @if($file->hasPermission($file,"print"))
        <a class="btn btn-default col-sm-2 print_file" href="#"><i class="fa fa-print"></i> Print</a>
        @endif

        @if($file->hasPermission($file,"download"))
        <a class="btn btn-default col-sm-2 download_file"
            href="/folder/{{$folder_id}}/file/{{$file->id}}/download"><i class="fa fa-download"></i> Download</a>
        @endif

        @if ($file->sourceCode())
        <a class="btn btn-default col-sm-2 download_file"
            href="/folder/{{$folder_id}}/file/{{$file->id}}/edit"><i class="fa fa-edit"></i> Edit</a>
        @endif

        @if($file->hasPermission($file,"delete"))
        <form action="/folder/{{$folder_id}}/file/{{$file->id}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE"/>
            <button class="btn btn-default col-sm-2" type="submit"><i class="fa fa-trash"></i> Delete</button>
        </form>
        @endif
    </div>
    <br>
    @if($file->hasPermission($file,"view"))
      <iframe class="file_content_area" id="file_content" name="file_content"
          src="/folder/{{$folder_id}}/file/{{$file->id}}/content">
      </iframe>
    @else
      <div class="alert alert-dismissable alert-info">
          <i class="fa fa-info"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <b>Alert!</b> You don't have permission to open file.
      </div>
    @endif

</section>

@stop
