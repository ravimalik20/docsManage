<div class="row folders_area tableclass">
    @if (isset($filerequests) && count($filerequests) > 0)

    <table class="table table-striped">
       <thead>
         <tr>
           <th>Description</th>
           <th>Type</th>
           <th>Messages</th>
           <th>Requested at</th>
           <th>Action</th>
         </tr>
       </thead>
       <tbody>
         @foreach ($filerequests as $filerequest)
         <tr class="file_request_row">
           <td class="description">{{ $filerequest->description }}</td>
           <td class="type">{{ $filerequest->type}}</td>
           <td>
             @if(count($filerequest->has_messages) > 0)
               @foreach($filerequest->has_messages as $message)
                 <p>{{ $message->message}}<p>
               @endforeach
             @endif
           </td>
           <td>{{ $filerequest->created_at}}</td>
           <td>
             @if(!$filerequest->is_uploaded)
             <a class="btn btn-sm requestfileupload fileAddModalclick" data-id="{{ $filerequest->id }}" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal" data-folderId = "{{ $filerequest->folder_id }}">
                 <i class="fa fa-file"></i> Upload a File
             </a>
             <a class="btn btn-sm fileRequestMessageModal"  data-toggle="modal" data-target="#fileRequestMessageModal" data-id="{{ $filerequest->id }}" data-receiver_id="{{ $filerequest->sender['sender_id'] }}">
               <i class="fa fa-envelope fa-1x" aria-hidden="true">Add Message</i>
            </a>
            @else
              <p>File has been uploaded at : {{ $filerequest->updated_at }} </p>
            @endif
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
