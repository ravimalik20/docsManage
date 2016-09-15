<div id="lhs-menu-div">

@if(Auth::check() && Auth::user()->role !="admin")
{{--*/
    $user = \App\User::find(Auth::user()->id);

    echo \App\Models\Folder::directoryTree($user);

/*--}}
@endif

</div>
