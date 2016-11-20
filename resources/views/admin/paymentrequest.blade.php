<div class="folders_area payment-request">
  <div class="row">
    @if(Session::has('selected_user'))
      <a class="btn btn-sm " href="#addpaymentamount" data-user = "{{Session::get('selected_user')}}" data-toggle="modal" data-target="#addpaymentamount" id="openaddpaymentamount">
      <i class="fa fa-credit-card"></i> Make Payment Request
      </a>
    @endif
  </div>
  <br/>
  <div class="row">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#in_complete">In Complete</a></li>
      <li><a data-toggle="tab" href="#complete">Complete</a></li>
    </ul>

    <div class="tab-content">
      <div id="in_complete" class="tab-pane fade in active">
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
              @if(!$payment_request->is_complete)
                 <tr>
                   <td>{{ $payment_request->name }}</td>
                   <td>{{ $payment_request->email }}</td>
                   <td>${{ ($payment_request->account_balance)?  $payment_request->account_balance : 0}}</td>
                   <td>${{ ($payment_request->amount)? $payment_request->amount : 0}}</td>
                   <td>{{ $payment_request->created_at}}</td>
                 </tr>
             @endif
             @endforeach
           </tbody>
          </table>
        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No In complete Request.</p>
        </div>
        @endif
      </div>
      <div id="complete" class="tab-pane fade">
        @if (isset($payment_requests) && count($payment_requests) > 0)
        <table class="table table-striped">
           <thead>
             <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Account Balance</th>
               <th>Amount</th>
               <th>Created At</th>
               <th>Updated At</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($payment_requests as $payment_request)
              @if($payment_request->is_complete)
                 <tr>
                   <td>{{ $payment_request->name }}</td>
                   <td>{{ $payment_request->email}}</td>
                   <td>${{ ($payment_request->account_balance)?  $payment_request->account_balance : 0}}</td>
                   <td>${{ ($payment_request->amount)? $payment_request->amount : 0}}</td>
                   <td>{{ $payment_request->created_at}}</td>
                   <td>{{ $payment_request->updated_at}}</td>
                 </tr>
              @endif
             @endforeach
           </tbody>
          </table>
        @else
        <div class="alert alert-info">
            <i class="fa fa-info"></i>
            <p> No Complete.</p>
        </div>
        @endif

      </div>
    </div>

  </div>
</div>
