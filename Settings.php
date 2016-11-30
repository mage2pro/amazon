<?php
// 2016-06-02
namespace Df\Amazon;
/** @method static Settings s() */
final class Settings extends \Df\Config\Settings {
	/**
	 * 2016-06-02
	 * @return void
	 */
	public function init() {dfc($this, function() {return
		!df_is_frontend() ? null : df_phtml(__CLASS__, 'init')
	;});}

	/**
	 * 2016-06-03
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
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_amazon/common';}
}


