<?php
namespace Dfe\LPA\Controller\Login;
use Df\Customer\External\ReturnT;
use Dfe\LPA\Customer;
use Dfe\LPA\Setup\InstallSchema;
/**
 * 2016-06-04
 * «Integrate with Your Existing Account System»
 * https://login.amazon.com/documentation/combining-user-accounts
 *
 * 2016-06-03
 * «Obtaining profile information»
 * https://payments.amazon.com/documentation/lpwa/201953190#button_widget_php
 *
 * 2016-06-04
 * Обратите внимание, что сервер Amazon сюда же перенаправляет покупателя в ситуации,
 * когда покупатель не авторизовался:
 * «If the user did not grant the request for access, or an error occurs,
 * the authorization service will redirect the user-agent (a user's browser)
 * to a URI specified by the client.
 * That URI will contain error parameters detailing the error.»
 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
 *
 * HTTP/l.l 302 Found
 * Location: https://client.example.com/cb#error=access_denied
 * &state=208257577ll0975l93l2l59l895857093449424
 *
 * 2016-06-05
 * Проверку на подобные сбои мы производим в методе @see \Dfe\LPA\Customer::validate()
 */
class Index extends ReturnT {
	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\ReturnT::customerClass()
	 * @used-by \Df\Customer\External\ReturnT::c()
	 * @return string
	 */
	protected function customerClass() {return Customer::class;}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\ReturnT::customerIdFieldName()
	 * @used-by \Df\Customer\External\ReturnT::customer()
	 * @return string
	 */
	protected function customerIdFieldName() {return InstallSchema::F__ID;}

	/**
	 * 2016-06-05
	 * https://code.dmitry-fedyuk.com/m2e/login-and-pay-with-amazon/blob/4f911a0d/view/frontend/web/login.js#L232
	 * @override
	 * @see \Df\Customer\External\ReturnT::redirectUrlKey()
	 * @used-by \Df\Customer\External\ReturnT::execute()
	 * @return string
	 */
	protected function redirectUrlKey() {return 'state';}
}