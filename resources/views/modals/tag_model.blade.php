<div class="modal fade" tabindex="-1" role="dialog" id="tagmodel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		<h4 class="modal-title">Add tags</h4>
      </div>
      <form id="tagform" method="post" action="/tag">
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="text" data-role="tagsinput" placeholder="Enter tag and press enter" class="form-control" name="tag">
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="submitTagform" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
