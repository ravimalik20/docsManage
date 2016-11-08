{{--*/
    use App\Models\Folder;
/*--}}

<div class="modal fade" tabindex="-1" role="dialog" id="fileAddModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>


		<h4 class="modal-title">Add File</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                  <select class="form-control folder-select" name="folder-select" id="folder-select">
                  </select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="description" placeholder="Enter Description" id="fileRequestDesc" disabled></textarea>
                </div>
                <div class="form-group">
                  <input class="form-control" name="type" placeholder="Enter Type" id="fileRequestType" disabled/>
                </div>

                <div class="form-group">
                    <form method="POST" class="dropzone dz-remove-click" id="file_upload_form" data-token="{{csrf_token()}}"
                    action="/">

                    @if(Auth::check() && Auth::user()->role  == "admin")
                      @if(Request::segment(1) == "user" && Request::segment(2) != "")
                        <input type="hidden" name="admin" value="true"/>
                        <input type="hidden" name="created_by" value="{{ Request::segment(2) }}"/>
                      @endif
                    @endif
                    <input type="hidden" id="filerequestId" name="filerequestId" value=""/>
                    </form>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default files_modal_close" data-dismiss="modal">Done</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
