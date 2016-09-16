<div class="row folders_area">

  @if (isset($users) && count($users) > 0)
  @foreach ($users as $user)
     <div class="folder col-lg-2 col-sm-2 col-xs-3">
          <div class="row">
            {{--*/
              $check = '';
              if(in_array($user->id, $managepermission)){
                $check = 'checked';
              }
              /*--}}
          <div class="col-lg-1 user-permission-check {{ $check }}">
              <input type="checkbox"  {{ $check }} name="userpermisson" class="userpermisson" value="{{$user->id}}" autocomplete="off">
          </div>
          <div class="col-lg-11">
              <div class="file_icon text-center">
                 <a><i class="fa fa-user fa-5x"></i></a>
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

<div class="row">
    <div class="col-lg-12 text-center">
        <a class="btn btn-primary user-manage-permission" href="javascript::void(0)">
              <i class="fa fa-key"></i> Update Manage Permission
        </a>
    </div>
</div>
