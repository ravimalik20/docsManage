<ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> /</a></li>
    @if (isset($path) && count($path) > 0)
    @foreach ($path as $p)
    <li class="active"><a href="/folder/{{$p->id}}">{{$p->name}}</a></li>
    @endforeach
    @endif
</ol>
