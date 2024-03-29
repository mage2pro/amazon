<?php
namespace Dfe\Amazon;
# 2016-06-02
/** @method static Settings s() */
final class Settings extends \Df\Config\Settings {
	/**
	 * 2016-06-03
	 * @used-by \Dfe\AmazonLogin\Button::jsOptions()
	 */
	function merchantId():string {return $this->v();}

	/**
	 * 2016-06-03 «Sandbox Mode?»
	 * @used-by \Dfe\AmazonLogin\Button::jsOptions()
	 * @used-by \Dfe\AmazonLogin\Customer::url()
	 */
	function test():bool {return $this->b();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'df_amazon/common';}
}