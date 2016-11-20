var Util = {};

Util.successMessage =  function(data) {
  var wrapDiv = '<div class="alert alert-dismissable '+data.type+'"><i class="fa '+data.icon+'"></i><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><p>'+data.message+'</p></div>';
  $('.content').prepend(wrapDiv);
}

$(document).ready(function(){

//payment from saved card
$('#payment_card button').click(function(){
  var _this = $(this);
  var $form = $('#payment_card');
  var token = $('#payment_card input[name=paymentcard]:checked').val();
  var amount = $('#amount').val();
  if(!token || !amount){
    $('.payment-errors').html('Please choose card for make payment.');
    $('.showerror').show();
    return false;
  }
  if(!checkValidAMount($('#amount'))){
    return;
  }

  _this.html('Processing <i class="fa fa-spinner fa-pulse"></i>');
  $.post('/payment', {
           token: token,
          _token: $('input[name=_token]').val(),
          amount: amount,
          payment_request_id: $('input[name=payment_request_id]').val()
      })
      .done(function(data, textStatus, jqXHR) {
          _this.html('Payment successful <i class="fa fa-check"></i>');
          //Util.successMessage({type:'alert-success', icon:'fa-check', message:data.message});
          $('#paymentCheckoutModal').modal('hide');
          window.location.reload();
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        if(textStatus == 'error') {
          _this.html('There was a problem').removeClass('success').addClass('error');
          /* Show Stripe errors on the form */
          $form.find('.payment-errors').text('Try refreshing the page and trying again.');
        }
        else if(jqXHR && jqXHR.responseJSON.message) {
          $form.find('.payment-errors').text(jqXHR.responseJSON.message);
          _this.html('Payment Confirm');
          _this.prop('disabled', false);
        } else  {
          _this.html('There was a problem').removeClass('success').addClass('error');
          /* Show Stripe errors on the form */
          $form.find('.payment-errors').text('Try refreshing the page and trying again.');
        }
          $form.find('.payment-errors').closest('.row').show();
      });

});
//when click on make payment button
$('.userpaymentcards').click(function(){
  var _this = $(this);
  $('input[name=payment_request_id]').val($(this).attr('data-request'));
  $.post('/paymentcards', {_token: $('input[name=_token]').val()})
        .done(function(data, status){
          $('.loader').hide();
          if(data.length){
            var tr = '';
            for(var i = 0; i < data.length; i++){
              tr += '<tr><td>xxxx xxxx xxxx '+data[i].card.last4+'</td><td>'+data[i].card.brand+'</td><td><input type="radio" name="paymentcard" value="'+data[i].token+'"></td></tr>';
            }
            $('#payment_card').show();
            $('#tbody').html(tr);
          } else {
            $('#payment_card').hide();
            $('#payment-form').show();
          }
          $('input[name=total_amount]').val(_this.attr('data-amount'));
          $('input[name=amount]').val(_this.attr('data-amount'));
        })
        .fail(function(data, status){
            alert('Something went wrong');
        });
});
var $form = $('#payment-form');
var PublishableKey = '';
$.ajax({
    url:'/getenv',
    type:'post',
    data: {envs:"STRIPE_KEY", _token: $('input[name=_token]').val()},
    success:function(response) {
      PublishableKey = response.STRIPE_KEY;
    }
});

/* If you're using Stripe for payments */
$('.subscribe').on('click',function(e){
    e.preventDefault();
    var _this = $(this);
    /* Abort if invalid form data */
    if (!validator.form()) {
        return;
    }
    if(!checkValidAMount($('#pay_amount'))){
      return;
    }
    /* Visual feedback */
    _this.html('Validating <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);
    Stripe.setPublishableKey(PublishableKey);
    /* Create token */
    var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
    var ccData = {
        number: $form.find('[name=cardNumber]').val().replace(/\s/g,''),
        cvc: $form.find('[name=cardCVC]').val(),
        exp_month: expiry.month,
        exp_year: expiry.year
    };

    Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
        if (response.error) {
            _this.html('Try again').prop('disabled', false);
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').closest('.row').show();
        } else {
            _this.html('Processing <i class="fa fa-spinner fa-pulse"></i>');
            $form.find('.payment-errors').closest('.row').hide();
            $form.find('.payment-errors').text("");
            var token = response.id;
            $.post('/payment', {
                     token: token,
                    _token: $('input[name=_token]').val(),
                    amount: $('#pay_amount').val(),
                    save_card: $('input[name=save_card]:checked').val() || false,
                    payment_request_id: $('input[name=payment_request_id]').val()
                })
                .done(function(data, textStatus, jqXHR) {
                    _this.html('Payment successful <i class="fa fa-check"></i>');
                    //Util.successMessage({type:'alert-success', icon:'fa-check', message:data.message});
                    $('#paymentCheckoutModal').modal('hide');
                    $('#payment-form').hide();
                    window.location.reload();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                  if(textStatus == 'error') {
                    _this.html('There was a problem').removeClass('success').addClass('error');
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                  }
                  else if(jqXHR && jqXHR.responseJSON.message) {
                      $form.find('.payment-errors').text(jqXHR.responseJSON.message);
                      _this.html('Payment Confirm');
                      _this.prop('disabled', false);
                    } else {
                      _this.html('There was a problem').removeClass('success').addClass('error');
                      /* Show Stripe errors on the form */
                      $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                    }
                    $form.find('.payment-errors').closest('.row').show();
                });
        }
    });
});

/* Fancy restrictive input formatting via jQuery.payment library*/
$('input[name=cardNumber]').payment('formatCardNumber');
$('input[name=cardCVC]').payment('formatCardCVC');
$('input[name=cardExpiry').payment('formatCardExpiry');

/* Form validation using Stripe client-side validation helpers */
jQuery.validator.addMethod("cardNumber", function(value, element) {
    return this.optional(element) || Stripe.card.validateCardNumber(value);
}, "Please specify a valid credit card number.");

jQuery.validator.addMethod("cardExpiry", function(value, element) {
    /* Parsing month/year uses jQuery.payment library */
    value = $.payment.cardExpiryVal(value);
    return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
}, "Invalid expiration date.");

jQuery.validator.addMethod("cardCVC", function(value, element) {
    return this.optional(element) || Stripe.card.validateCVC(value);
}, "Invalid CVC.");

var validator = $form.validate({
    rules: {
        cardNumber: {
            required: true,
            cardNumber: true
        },
        cardExpiry: {
            required: true,
            cardExpiry: true
        },
        cardCVC: {
            required: true,
            cardCVC: true
        }
    },
    highlight: function(element) {
        $(element).closest('.form-control').removeClass('success').addClass('error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-control').removeClass('error').addClass('success');
    },
    errorPlacement: function(error, element) {
        $(element).closest('.form-group').append(error);
    }
});

paymentFormReady = function() {
    if ($form.find('[name=cardNumber]').hasClass("success") &&
        $form.find('[name=cardExpiry]').hasClass("success") &&
        $form.find('[name=cardCVC]').val().length > 1) {
        return true;
    } else {
        return false;
    }
}

$form.find('.subscribe').prop('disabled', true);
var readyInterval = setInterval(function() {
    if (paymentFormReady()) {
        $form.find('.subscribe').prop('disabled', false);
        clearInterval(readyInterval);
    }
}, 250);

$('#addcard').click(function(){
  $('#payment_card').hide();
  $('#payment-form').show();
});

// check for valid amount
checkValidAMount = function (_this) {
  if(parseFloat($('input[name=total_amount]').val()) < parseFloat(_this.val())) {
    $('.payment-errors').html('Amount must be less than or equal to '+ $('input[name=total_amount]').val());
    $('.showerror').show();
    return false;
  }
  return true;
}

});
