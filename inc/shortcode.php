<?php

add_shortcode('easy_payments', 'easy_payments_func');
function easy_payments_func(){
    ob_start();


    // Get $pubishable_key and $secret_key for stripe.
    $emp_type_payment = get_option('emp_type_payment');
    
    if ( $emp_type_payment == '' ) {
        $emp_type_payment = 'sandbox';
    }

    if ( $emp_type_payment == 'sandbox' ) {
        $publishable_key    = get_option('sandbox_stripe_api_publishable_key');
        $secret_key         = get_option('sandbox_stripe_api_secret_key');
    } else if ( $emp_type_payment == 'livemode' ){
        $publishable_key    = get_option('livemode_stripe_api_publishable_key');
        $secret_key         = get_option('livemode_stripe_api_secret_key');
    }

    // Get client_id key and secret_id key for paypal.
    if ( $emp_type_payment == 'sandbox' ) {
        $client_id_key      = get_option('sandbox_paypal_api_key_client_id');
        $secret_id_key      = get_option('sandbox_paypal_api_key_secret_key');
    } else if ( $emp_type_payment == 'livemode' ) {
        $client_id_key      = get_option('livemode_paypal_api_key_client_id');
        $secret_id_key      = get_option('livemode_paypal_api_key_secret_key');
    }

    // Get notication message from setting plugin.
    $msg_notify         = get_option('success_message_payment');
    $msg_notify         = $msg_notify != '' ? $msg_notify : 'Thanks for your donation..';

    $min_price_php      = get_option('starting_amount_payment');

    if ( $min_price_php == '' ) {
        $min_price_php = 1;
    }

    $BASE_URL_PLUGIN    = plugin_dir_url(__FILE__);

    $min_price_php      = isset($min_price_php) ? (int)$min_price_php : 1;
    if ( $min_price_php > 1000 ) {
        $min_price_php = 1000;
    }

    if ( $publishable_key != NULL && $secret_key != NULL ) {
        ?>
        <div id="payment-font-end">
            <section class="title-amount"><h5>Amount</h5></section>
            
            <p>
                <input type="text" id="amount" readonly>
            </p>

            <input type="range" min="1" max="1000" step="1" value="<?php echo $min_price_php; ?>">
           
            <div id="slider-range"></div>

            <section class="tab_payment">
                <ul>
                    <li class="creadit-card__area active"><?php _e('Credit Card', 'epm_efe'); ?></li>
                    <li class="paypal__area"><?php _e('PayPal', 'epm_efe'); ?></li>
                </ul>
            </section> 

            <section class="form-option-payment" id="creadit-card__area">
                <form method="post" id="stripe-payment-form">
                    <!-- Input for email -->
                    <input type="hidden" name="price-to-charge" value="<?php echo $min_price_php; ?>">
                    <input type="hidden" name="action" value="stripe"/>
                    <input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
                    <input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
                    <div class="field email">
                        <label for="email-payment">Email</label>
                        <input type="email" id="email-payment" name="email-payment" placeholder="Email">

                        <span class="card-type">
                            <img src="<?php echo STRIPE_BASE_URL; ?>/images/envolope.svg" >
                        </span>
                    </div>
                    <!-- Input for seri account bank -->
                    <div class="field creadit-card">
                        <label for="creadit-card-payment"><?php _e('Credit Card', 'epm_efe'); ?></label>
                        <input type="text" maxlength="17" id="creadit-card-payment" name="creadit-card-payment" placeholder="Credit Card">
                        <span class="card-type changed">
                            <img src="<?php echo STRIPE_BASE_URL; ?>/images/credit-card.png" >
                        </span>
                    </div>
                    <!-- Input for expired day and CVV number -->
                    <div class="field two-columns">
                        <div class="columns1">
                            <label for="expiration-date">Expiration date</label>
                            <input type="text" id="expiration_date_payment" onkeyup="formatDate(this.value);" maxlength="5" name="expiration_date_payment" placeholder="Expiration date (MM/YY)">
                            <span class="card-type">
                                <img src="<?php echo STRIPE_BASE_URL; ?>/images/calendar.svg">
                            </span>
                        </div>
                        <div class="columns2">
                            <label for="cvc-number-payment"><?php _e('CVC', 'epm_efe'); ?></label>
                            <input type="password" id="cvc-number-payment" name="cvc-number-payment" placeholder="CVC">

                            <span class="card-type">
                                <img src="https://img.icons8.com/material/24/000000/padlock-outline.png">
                            </span>
                        </div>
                    </div>
                    <div class="field checkbox-custom__eap">
                        <label class="switch">
                            <input type="checkbox" name="set-monthly-donation-payment" class="checkbox-custom__eap" checked id="checkbox-custom__eap">
                            <span class="slider round"></span>
                            <span class="right-toggle-label"><?php _e('Make this donation monthly.', 'epm_efe'); ?></span>
                        </label>
                    </div>
                    <div class="field button-pay">
                        <div id="loader" style="display: none;">
                            <img alt="loader" src="<?php echo $BASE_URL_PLUGIN . '../images/LoaderIcon.gif'; ?>">
                        </div>
                        <button class="ep-btn__pay" id="stripe-submit"><?php _e('Pay', 'epm_efe'); ?></button>
                    </div>
                </form>
                <?php if(isset($_GET['payment']) && $_GET['payment'] == 'paid') { ?>
                    <div class="plugin-success__epm">
                        <?php echo $msg_notify; ?>
                    </div>
                <?php } ?>
            </section>

            <section class="form-option-payment" id="paypal__area">
                <div class="field checkbox-custom__eap">
                    <label class="switch">
                        <input type="checkbox" name="set-monthly-donation-payment" class="checkbox-custom__eap" checked id="checkbox-custom__eap">
                        <span class="slider round"></span>
                        <span class="right-toggle-label"><?php _e('Make this donation monthly.', 'epm_efe'); ?></span>
                    </label>
                </div>
                <div id="paypal-button-container"></div>
                <div id="paypal-notification"></div>
                <div id="paypal-error__client-id"></div>
            </section>
            <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $client_id_key; ?>&currency=USD&disable-funding=credit"></script>
            <script src="<?php echo STRIPE_BASE_URL; ?>/js/paypal-processing.js"></script>
            <script>
                var __price = <?php echo (int)$min_price_php; ?>;
                $( function() {
                    var min_price_payment = <?php echo $min_price_php; ?>;
                    
                    $( "#amount" ).val( "$" + min_price_payment );
                    $('input[type="range"]').rangeslider({
                        polyfill: false,
                        onSlide: function(pos, value) {
                            slideValue = value;
                            __price = slideValue;
                            $('input[name="price-to-charge"]').attr('value', slideValue);
                            $('input[name="amount"]').attr('value', slideValue);
                            $( "#amount" ).val( "$" + slideValue );
                        }
                    });
                });
            </script>
        </div>
        <?php 
    } else {
        ?>
        <div class="plugin-error__epm">
            You must be set payment's API Key for Stripe and Paypal to use this shortcode.
        </div>
        <?php
    }

    require 'style.php';

    return ob_get_clean();
}