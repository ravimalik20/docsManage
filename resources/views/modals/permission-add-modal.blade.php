<div class="modal fade" tabindex="-1" role="dialog" id="addPermissionModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     
	    
	
		<h4 class="modal-title">Manage File Permissions</h4>
      </div>
      <div class="modal-body">
      <form name="permissionAddForm" method="post" action="/permission"/>
          <div class="row">
              <h5>Select users<h5>

                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="documentId" id="document" value=""/>
                <input type="hidden" name="document_type" id="document_type" value=""/>
                <div class="col-lg-12 add_permission_area">
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary add_folder">Add Permission</button>
        </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
