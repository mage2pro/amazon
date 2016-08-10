<?php
namespace Df\Amazon\Settings\Login;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon» → «Login with Amazon» → «Credentials»
 * @method static Credentials s()
 */
class Credentials extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * «Client ID»
	 * @return string
	 */
	public function id() {return $this->v();}

	/**
	 * 2016-06-02
	 * «Client Secret»
	 * @return string
	 */
	public function secret() {return $this->p();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/amazon/login/credentials/';}
}


