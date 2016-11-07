{{--*/
  use App\FileRequest;
  /*--}}
<div class="modal fade" tabindex="-1" role="dialog" id="filerequestmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>



		<h4 class="modal-title">File Requests</h4>
      </div>
      <div class="modal-body">


	 @if(Auth::check() && Auth::user()->role =="admin")
	@if (\Session::has("selected_user") && \Session::get("selected_user") != 1)
	<!-- For Admins working as another user-->
	<p><a class="btn btn-sm newfilerequestmodal" href="#newfilerequestmodal" data-toggle="modal" data-target="#newfilerequestmodal">
                <i class="fa fa-plus-circle"></i> Make a File Request
            </a>
	</p>
	<table class="table">
  	  <th>Description</th>
      <th>Type</th>
      <th>Messages</th>
      <th>Cancel Request</th>
      <th>Send Message</th>
      @if(count(FileRequest::userfilerequest(Request::segment(2))) > 0)
      @foreach(FileRequest::userfilerequest(Request::segment(2)) as $filerequest)
        <tr>
      	  <td>{{ $filerequest->description }}</td>
          <td>{{ $filerequest->type }}</td>
          <td>
            @if(count($filerequest->has_messages) > 0)
              @foreach($filerequest->has_messages as $message)
                <p>{{ $message->message}}<p>
              @endforeach
            @endif
          </td>
          <td><a class="btn btn-sm cancel-file-request" data-id="{{ $filerequest->id }}"><i class="fa fa-trash fa-1x" aria-hidden="true"></a></td>
          <td><td> <a class="btn btn-sm fileRequestMessageModal"  data-toggle="modal" data-target="#fileRequestMessageModal" data-id="{{ $filerequest->id }}"><i class="fa fa-envelope fa-1x" aria-hidden="true"></a></td></td>
    	  </tr>
      @endforeach
      @endif
	  </table>
	@else
		<!-- For Admin working as himself-->
	<h1>Error - Admin has no file requests for himself</h1>
	@endif
@endif
<!-- For user working as himself-->
@if(Auth::check() && Auth::user()->role !="admin")
	<table class="table">
	  <th>Description</th> <th>Tax Year</th> <th>Type</th> <th>Filename</th><th></th>
	  <tr>
	  <td class="file_name">get file request descriptions</td> <td>get file request tax year</td> <td>get file request type</td> <td>get file request filename</td><td><i class="fa fa-upload fa-1x" aria-hidden="true"></td>
	  </tr>
	  <tr>
	  <td>McDonald's</td> <td>2012</td> <td>T4</td> <td>mymcdonaldsthing.pdf</td><td><i class="fa fa-upload fa-1x" aria-hidden="true"></td>
	  </tr>
	  </table>
@endif

  </div>

        <div class="modal-footer">
		<p>For Admin: The admin can request a file from the currently selected user.  The Request a File button will open the modal called "fileRequestModal" </p>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
