<div class="modal fade" tabindex="-1" role="dialog" id="folderAddModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         
    
    
		 

		<h4 class="modal-title">Add Folder</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="string" placeholder="Name" class="form-control" name="folder_name" data-token="{{csrf_token()}}">
                    @if(Auth::check() && Auth::user()->role == "admin")
                      @if(Request::segment(1) =="user" && Request::segment(2) != "")
                      <input type="hidden" name="admin" value="true"/>
                      <input type="hidden" name="user_id" value="{{ Request::segment(2) }}"/>
                      @endif
                    @endif
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_folder">Add</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
