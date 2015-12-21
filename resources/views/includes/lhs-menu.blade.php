<div id="lhs-menu-div">
{{--*/
    $user = \App\User::find(Auth::user()->id);

    echo \App\Models\Folder::directoryTree($user);
/*--}}
</div>
