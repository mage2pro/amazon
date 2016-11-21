<?php
// 2016-06-02
namespace Df\Amazon;
/** @method static Settings s() */
final class Settings extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * @return void
	 */
	public function init() {
		if (!isset($this->{__METHOD__})) {
			df_is_frontend() ? df_block_r(null, [], 'Df_Amazon::init') : null;
			$this->{__METHOD__} = true;
		}
	}

	/**
	 * 2016-06-03
	 * «Mage2.PRO» → «Payment» → «2Checkout» → «Live API Username»
	 * @return string
	 */
	public function merchantId() {return $this->v();}

	/**
	 * 2016-06-03
	 * «Sandbox Mode?»
	 * @return bool
	 */
	public function test() {return $this->b();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/amazon/';}
}


