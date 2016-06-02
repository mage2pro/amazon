<?php
namespace Dfe\LPA;
use Dfe\LPA\Settings\Login;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon»
 */
class Settings extends \Df\Core\Settings {
	/** @return Login */
	public function login() {return Login::s();}

	/**
	 * 2016-06-02
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/lpa/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


