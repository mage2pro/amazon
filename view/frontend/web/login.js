// 2016-06-03
define([
	'jquery', 'df'
], function($, df) {return (
	/**
	 * @param {Object} config
	 * @param {String} config.clientId
	 * @param {?Object} config.css
	 * @param {String} config.domId
	 * @param {String} config.merchantId
	 * @param {String} config.redirect
	 * @param {Boolean} config.sandbox
	 * @param {String} config.size
	 * @param {?String} config.style
	 * @param {String} config.type
	 * @param {?String} config.wrapper
	 * @returns void
	 */
	function(config) {
		/** @type {jQuery} HTMLDivElement */
		var $container = $(document.getElementById(config.domId));
		/**
		 * 2016-06-03
		 * Почему-то кнопка в шапке инициализируется дважды.
		 * Это происходит только в шапке, другие кнопки инициализируются правильно, единократно.
		 */
		if (!$container.hasClass('dfe-amazon-login')) {
			$container.addClass('dfe-amazon-login');
			if (df.defined(config.wrapper)) {
				$container.wrap(config.wrapper);
			}
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
					,size: config.size
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
					,type: config.type
					,authorization: function() {
						authRequest = amazon.Login.authorize({
							/**
							 * 2016-06-03
							 * https://payments.amazon.com/documentation/lpwa/201953980
							 *
							 * The popup parameter determines whether the buyer
							 * will be presented with a pop-up window to authenticate,
							 * or if the buyer will instead be redirected
							 * to an Amazon Payments page to authenticate.
							 *
							 * Use one of the following popup parameters:
							 *
							 * true — An Amazon Payments authentication screen is presented
							 * in a pop-up dialog where buyers can authenticate
							 * without ever leaving your website.
							 * This value is recommended for desktops
							 * where the button widget is presented on a secure page.
							 * Please be aware that this option requires
							 * the button to reside on an HTTPS page with a valid SSL certificate.
							 *
							 * false — The buyer is redirected to an Amazon Payments page
							 * within the same browser window.
							 * This value is recommended for smartphone optimized devices
							 * or if you are rendering the button widget on a non-secure page.
							 * Please be aware that the redirect URL must use HTTPS protocol
							 * and have a valid SSL certificate.
							 */
							popup: 'true'
							/**
							 * 2016-06-03
							 * https://payments.amazon.com/documentation/lpwa/201953980
							 * «profile»
							 * Gives access to the full user profile
							 * (username, email address, and userID) after login.
							 *
							 * «payments:widget»
							 * Required to show the Amazon Payments widgets
							 * (address and wallet widget) on your page.
							 * If used without the parameter below,
							 * it gives access to the full shipping address
							 * after ConfirmOrderReference call.
							 *
							 * «payments:shipping_address»:
							 * Gives access to the full shipping address
							 * via the GetOrderReferenceDetails API call
							 * as soon as an address has been selected in the address widget.
							 */
							,scope: 'profile payments:widget payments:shipping_address'
						}, config.redirect);
					}
				});
				// 2016-06-03
				// Помещаем это именно сюда, чтобы стили не применялись
				// раньше чем кнопка будет построена.
				// К сожалению, у кнопки не нашёл оповещения о завершении её построения.
				if (df.defined(config.style)) {
					$container.css($.parseJSON(config.style));
				}
				if (df.defined(config.css) && $.isPlainObject(config.css)) {
					$.each(config.css, function(selector, css) {
						$(selector).css($.parseJSON(css));
					});
				}
			});
		}
	});
});