<div class="modal fade" tabindex="-1" role="dialog" id="paymentCheckoutModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>


		<h4 class="modal-title">Checkout</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
              <!-- CREDIT CARD FORM STARTS HERE -->
              <input type="hidden" name="payment_request_id"/>
              <input type="hidden" name="total_amount"/>
           <div class="panel panel-default credit-card-box">
               <div class="panel-heading" >
                   <div class="row display-tr" >
                       <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >
                           <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                       </div>
                   </div>
               </div>
               <div class="panel-body">
                  <div class="loader"><i class="fa fa-spinner fa-pulse"></i></div>
                   <div class="payment_card" id="payment_card" style="display:none;">
                     <table class="table">
                       <th>Card</th>
                       <th>Brand</th>
                       <th>Choose</th>
                       <tbody id="tbody"></tbody>
                     </table>
                     <div class="row">
                         <div class="col-xs-12">
                             <div class="form-group">
                                 <label for="amount">Amount</label>
                                 <input type="text" class="form-control" id="amount" name="amount" required/>
                             </div>
                         </div>
                     </div>
                   <div class="row">
                     <a href="javascript:void(0);" id="addcard" class="addcard">Add Card</a>
                   </div>
                     <div class="row showerror" style="display:none;">
                         <div class="col-xs-12">
                             <p class="payment-errors"></p>
                         </div>
                     </div>
                     <button type="button" class="btn btn-success btn-lg btn-block">Payment Confirm</button>
                   </div>
                   <form role="form" id="payment-form" method="POST" action="javascript:void(0);" style="display:none;">
                       <div class="row">
                           <div class="col-xs-12">
                               <div class="form-group">
                                   <label for="cardNumber">CARD NUMBER</label>
                                   <div class="input-group">
                                       <input
                                           type="tel"
                                           class="form-control"
                                           name="cardNumber"
                                           placeholder="Valid Card Number"
                                           autocomplete="cc-number"
                                           required autofocus
                                       />
                                       <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-xs-7 col-md-7">
                               <div class="form-group">
                                   <label for="cardExpiry"><span class="visible-xs-inline">EXP</span> DATE</label>
                                   <input
                                       type="tel"
                                       class="form-control"
                                       name="cardExpiry"
                                       placeholder="MM / YY"
                                       autocomplete="cc-exp"
                                       required
                                   />
                               </div>
                           </div>
                           <div class="col-xs-5 col-md-5 pull-right">
                               <div class="form-group">
                                   <label for="cardCVC">CVC CODE</label>
                                   <input
                                       type="tel"
                                       class="form-control"
                                       name="cardCVC"
                                       placeholder="CVC"
                                       autocomplete="cc-csc"
                                       required
                                   />
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-xs-12">
                               <div class="form-group">
                                   <label for="amount">Amount</label>
                                   <input type="text" class="form-control" name="amount" id="pay_amount" required/>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-xs-12">
                               <div class="form-group">
                                   <label for="save_card"></label>
                                   <input type="checkbox" class="form-control" name="save_card" value="save_card"/> Save card
                               </div>
                           </div>
                       </div>
                       <div class="row showerror" style="display:none;">
                           <div class="col-xs-12">
                               <p class="payment-errors"></p>
                           </div>
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="subscribe btn btn-success btn-lg btn-block">Payment Confirm</button>
                       </div>
                  </form>
               </div>
           </div>
           <!-- CREDIT CARD FORM ENDS HERE -->

            <div class="form-group">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            </div>
            </div>
        </div>
      </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
