@if(Auth::check() && Auth::user()->role != 'admin')
<div class="row folders_area">
    @if (isset($users) && count($users) > 0)
    @foreach ($users as $user)
    <div class="folder col-lg-2 col-sm-2 col-xs-3">
        <div class="row">
            <!-- <div class="col-lg-1 folder_checkbox">
                <input type="checkbox" name="folders" value="{{$user->id}}" autocomplete="off">
            </div> -->
            <div class="col-lg-11">
                <div class="file_icon text-center">
                    @if(Auth::check() && Auth::user()->role == "admin")
                      <a href="/user/{{$user->id}}"><i class="fa fa-user fa-5x"></i></a>
                    @else
                      <a href="/shareduser/{{$user->id}}"><i class="fa fa-user fa-5x"></i></a>
                    @endif
                </div>
                <div class="file_name text-center">
                    <span>{{$user->name}}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endif
