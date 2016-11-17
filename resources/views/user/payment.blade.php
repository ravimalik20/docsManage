<div class="row folders_area">
  <div class="row col-lg-12 padding-18">
    <div class="col-lg-6">
      <h1> Account Balance: $ {{ (Auth::user()->account_balance)? Auth::user()->account_balance : 0 }}</h1>
    </div>
    <div class="col-lg-6">
      <p> Due Amount: $ {{ (Auth::user()->amount_due)? Auth::user()->amount_due : 0 }}</p>
    </div>

    <a class="btn btn-sm" id="userpaymentcards" href="#paymentCheckout" data-toggle="modal" data-target="#paymentCheckoutModal">
          <i class="fa fa-credit-card"></i> Make a Payment
    </a>
  </div>
  <div class="row col-lg-12 padding-30">
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
        <p> No payment logs exists.</p>
    </div>
    @endif
  </div>
</div>
