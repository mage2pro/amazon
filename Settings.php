<?php
# 2016-06-02
namespace Df\Amazon;
/** @method static Settings s() */
final class Settings extends \Df\Config\Settings {
	/**
	 * 2016-06-03
	 * @return string
	 */
	function merchantId() {return $this->v();}

	/**
	 * 2016-06-03 «Sandbox Mode?»
	 * @used-by \Dfe\AmazonLogin\Button::jsOptions()
	 * @used-by \Dfe\AmazonLogin\Customer::url()
	 * @return bool
	 */
	function test() {return $this->b();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_amazon/common';}
}


