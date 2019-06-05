// Render the PayPal button into #paypal-button-container
try {
    // console.log ( paypal );
    paypal.Buttons({
        style: {
            layout: 'horizontal'
        },
        // Set up the transaction
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: __price
                    }
                }]
            });
        },
        // Finalize the transaction
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                document.getElementById('paypal-notification').innerHTML =
                '<div class="wrapper">' +
                    '<div class="paypal-notification__seccess">' +
                        '<div class="text">' + stripe_vars.msg_success + '</div>' + 
                        '<div class="money-transfer">Price: ' + details.purchase_units[0].amount.value + '(' + details.purchase_units[0].amount.currency_code + ')</div>' +
                    '</div>'
                '</div>';

                // alert('Transaction completed by ' + details.payer.name.given_name + '!...');
            });
        }
    }).render('#paypal-button-container');
} catch( paypal ) {
    document.getElementById('paypal-error__client-id').innerHTML = '<div class="wrapper">Something went wrong with your Client/Product ID Paypal. Check it again and make sure it correctly.</div>';
}