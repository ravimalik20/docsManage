<div class="row folders_area tableclass">

  <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#open_requests">Open Requests</a></li>
      <li><a data-toggle="tab" href="#close_requests">Close Requests</a></li>
  </ul>

  <div class="tab-content">
      <div id="open_requests" class="tab-pane fade in active">
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
                @if(!$filerequest->is_uploaded)
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
                     <a class="btn btn-sm requestfileupload fileAddModalclick" data-id="{{ $filerequest->id }}" href="#fileAddModal" data-toggle="modal" data-target="#fileAddModal" data-folderId = "{{ $filerequest->folder_id }}">
                         <i class="fa fa-file"></i> Upload a File
                     </a>
                     <a class="btn btn-sm fileRequestMessageModal"  data-toggle="modal" data-target="#fileRequestMessageModal" data-id="{{ $filerequest->id }}" data-receiver_id="{{ $filerequest->sender['sender_id'] }}">
                       <i class="fa fa-envelope fa-1x" aria-hidden="true">Add Message</i>
                    </a>
                   </td>
                 </tr>
                @endif
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
      <div id="close_requests" class="tab-pane fade">
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
                @if($filerequest->is_uploaded)
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
                   <td><p>File has been uploaded at : {{ $filerequest->updated_at }} </p></td>
                 </tr>
                @endif
             @endforeach
           </tbody>
          </table>

        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No closed requests.</p>
        </div>
        @endif
      </div>
  </div>

</div>
