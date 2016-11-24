{{--*/
    use App\Models\Folder;
    use App\Models\File;
/*--}}

<div class="modal fade" tabindex="2" role="dialog" id="newfilerequestmodal" style="z-index:999999999999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>


		<h4 class="modal-title">Make a File Request</h4>
      </div>
      <div class="modal-body">
        <form action="/filerequest" method="post">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                  <select class="form-control folder-select" name="folderselect" id="folder-select"></select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="description" placeholder="Enter Description"></textarea>
                </div>
                <div class="form-group">
                  <input class="form-control" name="type" placeholder="Enter Type"/>
                </div>

                <div class="form-group">
                  <textarea class="form-control" name="message" placeholder="Enter Message"></textarea>
                </div>

                <div class="form-group">
                    <select class="form-control" name="tax_year">
                      {!! File::createTaxYear() !!}
                    </select>
                </div>

                <div class="form-group">
                  <input type="hidden" name="user_id" value="{{ Request::segment(2) }}"/>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default primary">submit</button>
      </div>
    </form>
    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
