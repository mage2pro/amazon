<?php
namespace Df\Amazon\Settings;
use Df\Amazon\Settings\Login\Locations;
use Magento\Framework\App\ScopeInterface as S;
/**
 * 2016-06-02
 * «Mage2.PRO» → «Login and Pay with Amazon» → «Login with Amazon»
 * @method static Login s()
 */
class Login extends \Df\Core\Settings {
	/** @return Locations */
	public function locations() {return Locations::s();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_amazon/login/';}
}


