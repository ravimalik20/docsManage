<div class="row folders_area">
  <div class="row col-lg-12">
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
</div>
