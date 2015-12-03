<ul class="sidebar-menu">
    <li class="active">
        <a href="#folderAddModal" data-toggle="modal" data-target="#folderAddModal">
            <i class="fa fa-plus"></i> <span>Add Folder</span>
        </a>
    </li>
    <li class="treeview">
        @if (isset($folders) && count($folders) > 0)
        @foreach ($folders as $folder)
        <a href="#">
            <i class="fa fa-folder"></i>
            <span>{{$folder->name}}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        @endforeach
        @endif
    </li>
</ul>
