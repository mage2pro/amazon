<?php
namespace Dfe\LPA\Settings\Login;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon» → «Login with Amazon» → «Credentials»
 */
class Credentials extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * «Client ID»
	 * @param null|string|int|S $s [optional]
	 * @return string
	 */
	public function id($s = null) {return $this->v(__FUNCTION__, $s);}

	/**
	 * 2016-06-02
	 * «Client Secret»
	 * @param null|string|int|S $s [optional]
	 * @return string
	 */
	public function secret($s = null) {return $this->p(__FUNCTION__, $s);}

	/**
	 * 2016-06-02
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/lpa/login/credentials/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


