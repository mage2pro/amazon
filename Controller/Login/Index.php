<?php
namespace Dfe\LPA\Controller\Login;
use Df\Customer\External\ReturnT;
use Dfe\LPA\Customer;
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
	protected function customerIdFieldName() {return InstallSchema::F__TOKEN_FOR_BUSINESS;}
}