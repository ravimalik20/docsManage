<div class="row folders_area">
  <div class="row col-lg-12 padding-18">
    <div class="col-lg-6">
      @if(Session::has('selected_user'))
        <a class="btn btn-sm " href="#addpaymentamount" data-user = "{{Session::get('selected_user')}}" data-toggle="modal" data-target="#addpaymentamount" id="openaddpaymentamount">
        <i class="fa fa-credit-card"></i> Make Payment Request
        </a>
      @endif
    </div>
  </div>
  <div class="row col-lg-12 padding-30">
    @if (isset($payment_requests) && count($payment_requests) > 0)
    <table class="table table-striped">
       <thead>
         <tr>
           <th>Name</th>
           <th>Email</th>
           <th>Account Balance</th>
           <th>Amount</th>
           <th>Created At</th>
         </tr>
       </thead>
       <tbody>
         @foreach ($payment_requests as $payment_request)
         <tr>
           <td>{{ $payment_request->name }}</td>
           <td>{{ $payment_request->email}}</td>
           <td>{{ $payment_request->account_balance}}</td>
           <td>{{ $payment_request->amount_due}}</td>
           <td>{{ $payment_request->created_at}}</td>
         </tr>
         @endforeach
       </tbody>
      </table>

    @else
    <div class="alert alert-info">
        <i class="fa fa-info"></i>
        <p> No payment requests.</p>
    </div>
    @endif
  </div>
</div>
