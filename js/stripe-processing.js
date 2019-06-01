Stripe.setPublishableKey(stripe_vars.publishable_key);

function disableLoader__enableButton() {
    jQuery('#stripe-submit').css('display', 'block').attr('disabled', false);
    jQuery('#loader').css('display', 'none');
}

function disableButton__enableLoader() {
    jQuery('#stripe-submit').css('display', 'none').attr('disabled', 'disabled');
    jQuery('#loader').css('display', 'block');
}

function stripeResponseHandler(status, response) {
    console.log ( response );
    if (response.error) {
		// show errors returned by Stripe
        jQuery('.payment-errors').remove();
        jQuery('.plugin-success__epm').remove();
        jQuery('.payment-errors').remove();
        jQuery('#payment-font-end').append('<div class="payment-errors">' + response.error.message + '</div>');
		disableLoader__enableButton();
    } else {
        // console.log ( response );
        var form$ = jQuery("#stripe-payment-form");
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        // and submit
        form$.get(0).submit();
    }
}

function verifyData(email, num_card, num_cvc, exp_date) {
    if ( email == '' || num_card == '' || num_cvc == '' || exp_date == '' ) {
        return false;
    }
    return true;
}

jQuery(document).ready(function($) {

    jQuery('#payment-font-end input[name="creadit-card-payment"]').keyup(function() {
        var __this      = jQuery(this);
        var __target    = jQuery('span.card-type.changed');
        var __val       = __this.val();
        var __len       = __val.length;
        if ( __len >= 12 ) {
            switch ( __val[0] ) {
                case '3' : {
                    __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/american-express.png" >');
                    break;
                }
                case '4' : {
                    __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/visa.png" >');
                    break;
                }
                case '5' : {
                    __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/mastercard.png" >');
                    break;
                }
                case '6' : {
                    __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/visa.png" >');
                    break;
                }
                default : {
                    __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/credit-card.png" >');
                }
            }
        } else if ( __len <= 5 ) {
            __target.empty().html('<img src="' + stripe_vars.baseUrlPlugin + '/images/credit-card.png" >');
        }
    });

    jQuery('#stripe-submit').click( function(event) {
        event.preventDefault();

        disableButton__enableLoader();
 
        // send the card details to Stripe
        var email       = jQuery('#email-payment').val();
        var num_card    = jQuery('#creadit-card-payment').val();
        var num_cvc     = jQuery('#cvc-number-payment').val();
        var exp_date    = jQuery('#expiration_date_payment').val();

        if ( !verifyData(email, num_card, num_cvc, exp_date) ) {

            disableLoader__enableButton();

            jQuery('.payment-errors').remove();
            jQuery('#payment-font-end').append('<div class="payment-errors">All Fields are required</div>');
            return false;
        }

        // console.log ( exp_date );
        if ( exp_date != '' ) {
            var exp_month   = exp_date.substring(0, 2);
            var exp_year    = exp_date.substring(3);
        }

        Stripe.createToken({
            number: num_card,
            cvc: num_cvc,
            exp_month: exp_month,
            exp_year: exp_year
        }, stripeResponseHandler);
 
        // prevent the form from submitting with the default action
        return false;
    } );
});