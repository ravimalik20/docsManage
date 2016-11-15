var Util = {};

Util.successMessage =  function(data) {
  var wrapDiv = '<div class="alert alert-dismissable '+data.type+'"><i class="fa '+data.icon+'"></i><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><p>'+data.message+'</p></div>';
  $('.content').prepend(wrapDiv);
}

$(document).ready(function(){
$('#payment_card button').click(function(){
  var _this = $(this);
  var $form = $('#payment_card');
  var token = $('#payment_card input[name=paymentcard]:checked').val();
  if(!token){
    return false;
  }

  _this.html('Processing <i class="fa fa-spinner fa-pulse"></i>');
  $.post('/payment', {
           token: token,
          _token: $('input[name=_token]').val()
      })
      .done(function(data, textStatus, jqXHR) {
          _this.html('Payment successful <i class="fa fa-check"></i>');
          Util.successMessage({type:'alert-success', icon:'fa-check', message:data.message});
          $('#paymentCheckoutModal').modal('hide');
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
          _this.html('There was a problem').removeClass('success').addClass('error');
          /* Show Stripe errors on the form */
          $form.find('.payment-errors').text('Try refreshing the page and trying again.');
          $form.find('.payment-errors').closest('.row').show();
      });

});

$('#userpaymentcards').click(function(){
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
                    _token: $('input[name=_token]').val()
                })
                .done(function(data, textStatus, jqXHR) {
                    _this.html('Payment successful <i class="fa fa-check"></i>');
                    Util.successMessage({type:'alert-success', icon:'fa-check', message:data.message});
                    $('#paymentCheckoutModal').modal('hide');
                    $('#payment-form').hide();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    _this.html('There was a problem').removeClass('success').addClass('error');
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text('Try refreshing the page and trying again.');
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

});