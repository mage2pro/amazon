<?php
namespace Dfe\LPA\Block;
use Dfe\LPA\Settings as S;
use Dfe\LPA\Settings\Login\Credentials as C;
use Magento\Framework\View\Element\AbstractBlock;
/**
 * 2016-06-02
 * «Login with Amazon» button
 */
class Login extends AbstractBlock {
	/**
	 * 2016-06-03
	 * @override
	 * @see AbstractBlock::_toHtml()
	 * @return string
	 */
	protected function _toHtml() {
		return
			!S::s()->enable()
			? ''
			: (
				df_customer_logged_in()
				? df_x_magento_init('Dfe_LPA/invalidate')
				: df_x_magento_init('Dfe_LPA/login', $this['jsOptions'] + [
					'clientId' => C::s()->id()
					,'domId' => $this->domId()
					,'loggedIn' => df_customer_logged_in()
					,'merchantId' => S::s()->merchantId()
					,'redirect' => df_url('dfe-lpa/login', ['_secure' => true])
					,'sandbox' => S::s()->test()
				])
				//. df_link_inline(df_asset_name('Dfe_LPA::login.css'))
				. df_tag('div', ['id' => $this->domId()])
			)
		;
	}

	/**
	 * 2016-06-03
	 * @return string
	 */
	private function domId() {
		if (!isset($this->{__METHOD__})) {
			$this->{__METHOD__} = df_uid(4, 'dfe-amazon-');
		}
		return $this->{__METHOD__};
	}

	/** @return string */
	private function e() {
		return df_tag('li', [], df_tag('div', ['id' => $this->domId()]));
	}

	/**
	 * 2016-06-03
	 * @return string
	 */
	private function widgetUrl() {
		return df_cc_url(
			'https://static-na.payments-amazon.com/OffAmazonPayments/us'
			,S::s()->test() ? 'sandbox' : null
			,'js/Widgets.js?sellerId=' . S::s()->merchantId()
		);
	}
}


