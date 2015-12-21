<div class="modal fade" tabindex="-1" role="dialog" id="fileAddModal">
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
                    <form method="POST" class="dropzone" id="file_upload_form" data-token="{{csrf_token()}}"
                    @if (isset($folder))
                        action="/folder/{{$folder->id}}/file"
                        data-folder-id="{{$folder->id}}"
                    @else
                        action="/folder/0/file"
                    @endif
                    >
                    </form>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default files_modal_close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_folder">Add</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
