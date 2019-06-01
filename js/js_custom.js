function check_click() {
	$('section.form-option-payment').hide();
	$('#creadit-card__area').show();
	$('.tab_payment ul li').click(function(){
		$('.payment-errors').remove();
		$('.tab_payment ul li').removeClass('active');
		$(this).addClass('active');
		var __target_id = $(this)[0].classList[0];
		$('section.form-option-payment').hide();
		$('#' + __target_id).show();
	});
}

function formatDate(sValue) {
    if (sValue.length == 2) {
    	var key = event.which || event.keyCode || event.charCode;
    	if (key != 8) {
    		document.forms[0].expiration_date_payment.value = sValue + "/";	
    	}
    }
}
function validDate(sValue) {
    var bad = false;
    var dTest = new Date(sValue);

    if (isNaN(dTest.getTime()))
        bad = true;

    if (dTest.getDate() != sValue.substring(3,5))
        bad = true;

    if (bad) alert("Please enter a valid date.");
}

$(document).ready(function(){
	check_click();
});