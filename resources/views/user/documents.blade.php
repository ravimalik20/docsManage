<div class="row folders_area">
        @if (isset($documents['folders']) && count($documents['folders']) > 0)
        @foreach ($documents['folders'] as $f)
        <div class="folder col-lg-2 col-sm-2 col-xs-3">
            <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="folders" value="{{$f->id}}" autocomplete="off">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon text-center">
                        <a href="/user/{{ $user->id }}/folder/{{$f->id}}"><i class="fa fa-folder fa-5x"></i></a>
                    </div>
                    <div class="file_name text-center">
                        <span>{{$f->name}}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        @if (isset($documents['files']) && count($documents['files']) > 0)
        @foreach ($documents['files'] as $fs)
        <div class="file col-lg-2 col-sm-2 col-xs-3 text-center">
            <div class="row">
                <div class="col-lg-1 folder_checkbox">
                    <input type="checkbox" name="files" autocomplete="off" value="{{$fs->id}}">
                </div>
                <div class="col-lg-11">
                    <div class="file_icon">
                        <a
                        @if (isset($folder))
                            href="/folder/{{$folder->id}}/file/{{$fs->id}}"
                        @else
                            href="/folder/0/file/{{$fs->id}}"
                        @endif
                        ><i class="fa fa-file fa-5x"></i></a>
                    </div>
                    <div class="file_name">
                        <span>{{$fs->name}}</span>
                    </div>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                    <div class="permissionbtn125">
                      <a class="btn btn-sm menu-middle-permission add_permision_btn" data-type="file" data-id="{{$fs->id}}" href="javascript:void(0)">
                          <i class="fa fa-key"></i> add permission
                      </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @endif
</div>
