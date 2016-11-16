<div class="modal fade" tabindex="-1" role="dialog" id="addpaymentamount">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		<h4 class="modal-title">Add Amount Due</h4>
      </div>
      <form id="addpaymentamountuser" method="post" action="/add_payment/">
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="text" placeholder="Amount" class="form-control" name="amount">
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
