// 2016-06-03
define([
	'jquery', 'df'
], function($, df) {return (
	/**
	 * @param {Object} config
	 * @param {String} config.clientId
	 * @param {String} config.domId
	 * @param {String} config.merchantId
	 * @param {Boolean} config.sandbox
	 * @returns void
	 */
	function(config) {
		$(document.getElementById(config.domId)).addClass('dfe-amazon-login');
		window.onAmazonLoginReady = function() {amazon.Login.setClientId(config.clientId);};
		/**
		 * 2016-06-03
		 * Сделал по аналогии с
		 * https://github.com/amzn/amazon-payments-magento-plugin/blob/v1.4.2/app/code/community/Amazon/Payments/Block/Login/Script.php#L42
		 *https://github.com/amzn/amazon-payments-magento-plugin/blob/v1.4.2/app/code/community/Amazon/Payments/Block/Script.php#L56
		 */
		/** @type {String} */
		var widgetUrl = df.array.clean([
			'https://static-na.payments-amazon.com/OffAmazonPayments/us'
			,config.sandbox ? 'sandbox' : null
			,'js/Widgets.js?sellerId=' + config.merchantId
		]).join('/');
		require([widgetUrl], function() {
			var authRequest;
			/**
			 * 2016-06-03
			 * «Login and Pay with Amazon Integration Guide» → «Widgets» → «Button widgets»
			 * https://payments.amazon.com/documentation/lpwa/201953980
			 */
			OffAmazonPayments.Button(config.domId, config.merchantId, {
				/**
				 * 2016-06-03
				 * «The color parameter is an optional parameter for selecting a button color.»
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 */
				color: 'Gold'
				/**
				 * 2016-06-03
				 * «The size parameter is an optional parameter for selecting a button size.»
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 */
				,size: 'small'
				/**
				 * 2016-06-03
				 * «The type parameter is an optional parameter
				 * for indicating the type of button image
				 * that you want to select for your web page.
				 *
				 * Note that if you decide not to specify a value for type,
				 * the LwA (Login with Amazon) button will be set as the default value.
				 * The following table shows the valid type parameter values,
				 * button descriptions, and sample button images.»
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 */
				,type: 'Login'//'LwA'
				,authorization: function() {
					authRequest = amazon.Login.authorize ({
						scope: 'SCOPES'
						, popup: 'POPUP_PARAMETER'
					}
					, 'REDIRECT_URL'
				);}
			});
		});
	});
});