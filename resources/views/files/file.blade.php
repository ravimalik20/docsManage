@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    @include('includes.directory-path')
</section>

<!-- Main content -->
<section class="content">

    <iframe src="{{$file_path}}" class="file_content_area">
    </iframe>

</section>

@stop
