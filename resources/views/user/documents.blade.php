<div class="metadata" style="display:hidden;"
    @if (isset($user_managed_id))
        data-id="{{$user_managed_id}}"
    @endif
></div>

<div class="row folders_area">
    <div class="col-lg-12">
        {!! $user->renderFolderStructureTable() !!}
    </div>
</div>
