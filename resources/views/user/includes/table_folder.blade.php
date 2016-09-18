<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion"
            @if (isset($folder))
                href="#collapse{{$folder->id}}"
            @else
                href="#collapse0"
            @endif
        aria-expanded="true" aria-controls="collapseOne">
            @if (isset($folder))
                {{ $folder->name }}
            @else
                root
            @endif
        </a>
      </h4>
    </div>
    <div
        @if (isset($folder))
            id="collapse{{$folder->id}}"
        @else
            id="collapse0"
        @endif

    class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">

