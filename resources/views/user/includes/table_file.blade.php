<tr>
    <td class="file_name"><a href="/folder/{{$file->folder_id}}/file/{{$file->id}}">{{ $file->name }}</a></td>
    <td class="file_description">{{ substr($file->description, 0, 50) }}</td>
    <td class="file_type">{{$file->type}}</td>
    <td class="file_year">{{ $file->created_at->format("Y") }}</td>
    <td class="file_print"></td>
    <td class="file_permission">
        @if((Auth::check() && Auth::user()->role == 'admin') || \App\Models\Permission::canManage(\Auth::user()->id, $file->created_by))
        <a class="menu-middle-permission add_permision_btn" data-type="file" data-id="{{$file->id}}" href="javascript:void(0)"
            data-toggle="tooltip" title="add permission"
        >
            <i class="fa fa-key"></i>
        </a>

        @endif
    </td>
    <td class="file_download">
        <a href="/folder/{{$file->folder_id}}/file/{{$file->id}}/download" data-toggle="tooltip" title="download">
            <i class="fa fa-download"></i>
        </a>
    </td>
    <td class="file_delete123456">
        @if($file->hasPermission($file,"delete") || \App\Models\Permission::canManage(\Auth::user()->id, $file->created_by))
            <a href="/delete/{{ $file->id }}/file" data-toggle="tooltip" onclick="return confirm('Are you sure?')" title="Delete" class="form_submit_link123">
                <i class="fa fa-trash"></i>
            </a>
        @endif
    </td>
</tr>
