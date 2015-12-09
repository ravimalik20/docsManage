@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">

    <iframe class="file_content_area" src="/folder/{{$folder_id}}/file/{{$file->id}}/content">
    </iframe>

</section>

@stop
