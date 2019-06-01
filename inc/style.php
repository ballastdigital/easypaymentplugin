<?php
	$main_color = get_option('epm_main_color');
	$main_color = $main_color != '' ? $main_color : '#377ab7';

	$main_font_family = get_option('epm_font_family');
	$main_font_family = $main_font_family != '' ? $main_font_family : 'Helvetica';

	$main_font_size = get_option('epm_font_size');
	$main_font_size = $main_font_size != '' ? $main_font_size : '16';
	?>
	<?php echo '<style>'; ?>
	:root {
	  --main-color: <?php echo $main_color; ?>;
	  --main-font-family: <?php echo $main_font_family; ?>;
	  --main-font-size: <?php echo $main_font_size; ?>;
	}
	/* CSS FONT END */
	#payment-font-end{
		/*width: 70%;*/
		min-height: 300px;
		margin: 0 auto;
		/*padding: 40px 50px 40px 50px;*/
	}
	.title-amount h5{
		text-align: center;
		font-size: 16px;
		font-family: sans-serif;
		font-weight: normal;
		color: #1d0f0f;
	}
	#amount{
		width: 100% !important;
		text-align: center;
		background: no-repeat !important;
		border: 0;
		font-family: var(--main-font-family);
		color: var(--main-color);
	    font-weight: bold;
	    font-size: 30px;
	}
	.tab_payment ul li{
		display: inline-block;
	}
	.tab_payment ul{
		text-align: center;
	  margin-bottom: 0;
	}
	.tab_payment ul li{
		cursor: pointer;
		list-style: none !important;
		padding: 20px 20px 10px 20px !important;
	}
	.tab_payment ul li::before{
		display: none;
	}
	.activepayment{
		color: var(--main-color);
		border-bottom: 2px solid;
	}
	#stripe-payment-form label{
		width: 100%;
		float: left;
		color: #969393;
	  font-weight: normal;
	  font-size: 15px;
	}
	#paypal__area label {
		width: 100%;
		float: left;
		color: #969393;
	  font-weight: normal;
	  font-size: 15px;
	}
	#stripe-payment-form input{
		width: 100%;
		background: no-repeat;
		border: none;
	  border-bottom: 1px solid #c5c2c2;
	  outline: none !important;
	  font-family: var(--main-font-family);
	}
	div#payment-font-end {
	  font-family: var(--main-font-family);
	  font-size: var(--main-font-size);
	}

	section.tab_payment {
	  border-bottom: 1px solid #ddd;
	  /*height: 70px;*/
	  margin-bottom: 20px;
	}

	#payment-font-end .tab_payment ul li.active {
	  color: var(--main-color);
	  border-bottom: 2px solid var(--main-color);
	}
	#stripe-payment-form input::placeholder {
		font-family: var(--main-font-family);
		color: normal;
	}
	#payment-font-end .form-option-payment .field {
	  margin-bottom: 40px;
	  padding-bottom: 20px;
	  position: relative;
	}
	#payment-font-end .field.two-columns {
	  display: inline-grid;
	  grid-template-columns: repeat(2, 1fr);
	  grid-gap: 20px;
	  width: 100%;
	}
	#payment-font-end input#checkbox-custom__eap {
	    width: unset;
	}
	#payment-font-end button.ep-btn__pay {
	  background: var(--main-color);
	  width: 200px;
	  border-radius: 40px;
	  font-weight: normal;
	  transition: all .3s;
	  margin: 0 auto;
	}
	#payment-font-end button.ep-btn__pay:hover {
	  background: var(--main-color);
		box-shadow: 0px 6px 20px 0px rgba(0,0,0,0.2);
	}
	#payment-font-end .field.button-pay {
	  text-align: center;
	}
	#payment-font-end label[for="checkbox-custom__eap"] {
	  padding-bottom: 40px;
	}

	span.card-type {
	    position: absolute;
	    height: 10px;
	    font-family: FontAwesome;
	    top: 32px;
	    color: var(--main-color);
	    right: 0;
	}

	#slider-range .display-1 {
		display: none;
	}

	span.card-type > img {
	    height: 30px;
	    margin-top: 8px;
	}
	span.card-type.changed > img {
	    height: 45px;
	    margin: 0;
	}
	#payment-font-end .field.two-columns div {
	  position: relative;
	}

	.switch {
	  position: relative;
	  display: inline-block;
	  width: 100%;
	  height: 30px;
	}

	.switch input { 
	  opacity: 0;
	  width: 0;
	  height: 0;
	}

	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 27px;
	  left: 4px;
	  bottom: 2px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: var(--main-color);
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	  width: 60px !important;
	}

	.slider.round:before {
	  border-radius: 50%;
	}

	span.right-toggle-label {
	    margin-left: 60px;
	}

	.plugin-error__epm {
	  border-left: 3px solid #FF7361;
	  padding-left: 20px;
	  background: #eaeaea;
	  font-family: var(--main-font-family);
	  font-size: 20px;
	  padding-top: 10px;
	  padding-bottom: 10px;
	}
	.payment-errors {
	  font-family: var(--main-font-family);
	  margin: 0 auto !important;
	  padding: 40px 50px 40px 50px;
	  background: #dcdcdc;
	  border-left: 8px solid #e63d3d;
	  box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.2);
	}

	.plugin-success__epm {
	  font-family: var(--main-font-family);
	  margin: 0 auto !important;
	  padding: 40px 50px 40px 50px;
	  background: #dcdcdc;
	  border-left: 8px solid var(--main-color);
	  box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.2);
	}
	#paypal-notification .wrapper {
	  border-top: 1px solid #ddd;
	  padding-top: 20px;
	}
	.paypal-notification__seccess {
	  border: 1px solid var(--main-color);
	  border-bottom-right-radius: 4px;
	  border-top-right-radius: 4px;
	  border-left: 6px solid var(--main-color);
	  padding: 10px;
	}
	div#paypal-error__client-id .wrapper {
	  font-family: var(--main-font-family);
	  padding: 40px 50px 40px 50px;
	  background: #dcdcdc;
	  border-left: 8px solid #e63d3d;
	  box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.2);
	}
	div#loader > img {
	  width: 60px;
	}
	.ui-state-hover,
	.ui-widget-content .ui-state-hover,
	.ui-widget-header .ui-state-hover,
	.ui-state-focus,
	.ui-widget-content .ui-state-focus,
	.ui-widget-header .ui-state-focus,
	.ui-button:hover,
	.ui-button:focus {
		border: 1px solid #cccccc;
		background: <?php echo $main_color; ?>;
		font-weight: normal;
		color: #2b2b2b;
	}
	.ui-state-default,
	.ui-widget-content .ui-state-default,
	.ui-widget-header .ui-state-default,
	.ui-button,

	/* We use html here because we need a greater specificity to make sure disabled
	works properly when clicked or hovered */
	html .ui-button.ui-state-disabled:hover,
	html .ui-button.ui-state-disabled:active {
		border: 1px solid #c5c5c5;
		background: <?php echo $main_color; ?>;
		font-weight: normal;
		color: #454545;
	}
	.ui-widget-header {
		background: <?php echo $main_color; ?>;
	}
	<?php echo '</style>';