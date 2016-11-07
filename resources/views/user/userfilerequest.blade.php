<div class="row folders_area tableclass">
    @if (isset($filerequests) && count($filerequests) > 0)

    <table class="table table-striped">
       <thead>
         <tr>
           <th>Description</th>
           <th>Type</th>
           <th>Requested at</th>
           <th>Action</th>
         </tr>
       </thead>
       <tbody>
         @foreach ($filerequests as $filerequest)
         <tr class="file_request_row">
           <td class="description">{{ $filerequest->description }}</td>
           <td class="type">{{ $filerequest->type}}</td>
           <td>{{ $filerequest->created_at}}</td>
           <td>
             <a class="btn btn-sm requestfileupload fileAddModalclick" data-id="{{ $filerequest->id }}" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal">
                 <i class="fa fa-file"></i> Upload a File
             </a>
           </td>
         </tr>
         @endforeach
       </tbody>
      </table>

    @else
    <div class="alert alert-info">
        <i class="fa fa-info"></i>
        <p> No new requests.</p>
    </div>
    @endif
</div>
