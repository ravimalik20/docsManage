<div class="menu">
    @if (isset($pathStr))
        {{$pathStr}}
    @endif

    @if (Auth::check() && \App\User::authUserType() == \App\User::TYPE_ADMIN)

        @include("includes.admin-menu")

    @elseif (Auth::check() && \App\User::authUserType() == \App\User::TYPE_ADMIN_CLIENT)
        @include("includes.admin-workingas")    
       

    @elseif (Auth::check() && \App\User::authUserType() == \App\User::TYPE_CLIENT)
        @include("includes.client-menu")
    @elseif (Auth::check() && \App\User::authUserType() == \App\User::TYPE_CLIENT_CLIENT)
        @include("includes.client-workingas")
    @endif
</div>

@include('includes.directory-path')

<!-- This page loads the correct menu file for the user state.  Each menu file will load the correct menu for the page -->