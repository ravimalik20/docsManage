{{--*/
    use App\Models\Folder;
/*--}}

<div class="modal fade" tabindex="-1" role="dialog" id="fileRequestMessageModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>


		<h4 class="modal-title">Send Message</h4>
      </div>
      <div class="modal-body">
        <form action="/send-message" method="post">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                  <textarea class="form-control" name="message" placeholder="Enter Message"></textarea>
                </div>
                <div class="form-group">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                  <input type="hidden" name="file_request_id" value="" id="file_request_id"/>
                  <input type="hidden" name="file_message_receiver" value="" id="file_message_receiver"/>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default primary">send</button>
      </div>
    </form>
    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
