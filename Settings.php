<?php
namespace Df\Amazon;
use Df\Amazon\Settings\Login;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon»
 *
 * @method static Settings s()
 */
class Settings extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * @return void
	 */
	public function init() {
		if (!isset($this->{__METHOD__})) {
			if (df_is_frontend()) {
				$r = df_block_r(null, [], 'Df_Amazon::init');
			}
			$this->{__METHOD__} = true;
		}
	}

	/** @return Login */
	public function login() {return Login::s();}

	/**
	 * 2016-06-03
	 * «Mage2.PRO» → «Payment» → «2Checkout» → «Live API Username»
	 * @param null|string|int|S $s [optional]
	 * @return string
	 */
	public function merchantId($s = null) {return $this->v(__FUNCTION__, $s);}

	/**
	 * 2016-06-03
	 * «Sandbox Mode?»
	 * @param null|string|int|S $s [optional]
	 * @return bool
	 */
	public function test($s = null) {return $this->b(__FUNCTION__, $s);}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/amazon/';}
}


