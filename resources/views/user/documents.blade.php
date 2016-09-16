<div class="metadata" style="display:hidden;"
    @if (isset($user_managed_id))
        data-id="{{$user_managed_id}}"
    @endif
></div>

<div class="row folders_area">
    <table class="table">
        <thead>
        </thead>

        <tbody>
            {!! $user->renderFolderStructureTable() !!}
        </tbody>
    </table>
</div>
