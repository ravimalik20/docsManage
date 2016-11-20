<div class="folders_area payment-request">
  <div class="row col-lg-12">
    <div class="col-lg-6">
      <h1> Account Balance: $ {{ (Auth::user()->account_balance)? Auth::user()->account_balance : 0 }}</h1>
    </div>
    <div class="col-lg-6">
      <p> Due Amount: $ {{ (Auth::user()->amount_due)? Auth::user()->amount_due : 0 }}</p>
    </div>

  </div>


  <div class="row payment-request">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#in_complete">In Complete</a></li>
      <li><a data-toggle="tab" href="#complete">Complete</a></li>
      <li><a data-toggle="tab" href="#paymentlog">Payment Log</a></li>
    </ul>

    <div class="tab-content">
      <div id="in_complete" class="tab-pane fade in active">
        @if (isset($payment_requests) && count($payment_requests) > 0)
        <table class="table table-striped">
           <thead>
             <tr>
               <th>Name</th>
               <th>Amount</th>
               <th>Created At</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($payment_requests as $paymentlog)
              @if(!$paymentlog->is_complete)
               <tr>
                 <td>{{ $paymentlog->name }}</td>
                 <td>{{ $paymentlog->current_amount }}</td>
                 <td>{{ $paymentlog->created_at}}</td>
                 <td>
                   <a class="btn btn-sm userpaymentcards" data-request="{{ $paymentlog->id }}" data-amount="{{ $paymentlog->current_amount }}" href="#paymentCheckout" data-toggle="modal" data-target="#paymentCheckoutModal">
                         <i class="fa fa-credit-card"></i> Make a Payment
                   </a>
                 </td>
               </tr>
               @endif
             @endforeach
           </tbody>
          </table>
        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No in complete requests.</p>
        </div>
        @endif
      </div>

      <div id="complete" class="tab-pane fade in">
        @if (isset($payment_requests) && count($payment_requests) > 0)
        <table class="table table-striped">
           <thead>
             <tr>
               <th>Name</th>
               <th>Amount</th>
               <th>Created At</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($payment_requests as $paymentlog)
              @if($paymentlog->is_complete)
               <tr>
                 <td>{{ $paymentlog->name }}</td>
                 <td>{{ $paymentlog->amount }}</td>
                 <td>{{ $paymentlog->created_at}}</td>
                 <td>
                   <a class="btn btn-sm userpaymentcards" data-request="{{ $paymentlog->id }}" data-amount="{{ $paymentlog->amount }}" href="#paymentCheckout" data-toggle="modal" data-target="#paymentCheckoutModal">
                         <i class="fa fa-credit-card"></i> Make a Payment
                   </a>
                 </td>
               </tr>
               @endif
             @endforeach
           </tbody>
          </table>
        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No in complete requests.</p>
        </div>
        @endif
      </div>

      <div id="paymentlog" class="tab-pane fade in">
        @if (isset($paymentlogs) && count($paymentlogs) > 0)
        <table class="table table-striped">
           <thead>
             <tr>
               <th>Amount</th>
               <th>status</th>
               <th>Created At</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($paymentlogs as $paymentlog)
             <tr>
               <td>{{ $paymentlog->amount }}</td>
               <td>{{ $paymentlog->status}}</td>
               <td>{{ $paymentlog->created_at}}</td>
             </tr>
             @endforeach
           </tbody>
          </table>
        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No payment logs.</p>
        </div>
        @endif
      </div>


    </div>
  </div>

</div>
