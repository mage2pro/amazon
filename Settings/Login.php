<?php
namespace Dfe\LPA\Settings;
use Dfe\LPA\Settings\Login\Locations;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon» → «Login with Amazon»
 */
class Login extends \Df\Core\Settings {
	/** @return Locations */
	public function locations() {return Locations::s();}

	/**
	 * 2016-06-02
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/lpa/login/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


