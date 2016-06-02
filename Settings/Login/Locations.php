<?php
namespace Dfe\LPA\Settings\Login;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon» → «Login with Amazon» → «Button Locations»
 */
class Locations extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/lpa/login/locations/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


