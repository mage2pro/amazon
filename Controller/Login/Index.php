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
 *
 * 2016-06-06
 * Заметил, что если сменить имя владельца тестовой учётной записи в Amazon Seller Central,
 * то запросы к https://api.sandbox.amazon.com/user/profile продолжают возвращать прежнее имя.
 * https://mage2.pro/t/1739
 * http://sellercentral.amazon.com/gp/contact-us/contact-amazon-form.html?caseID=1769644581
 *
 * @method \Dfe\LPA\Customer c()
 */
class Index extends ReturnT {
	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Customer\External\ReturnT::addressData()
	 * @used-by \Df\Customer\External\ReturnT::register()
	 * @return array(string => mixed)
	 */
	protected function addressData() {return ['postcode' => $this->c()->postalCode()];}

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
	 * Не всегда имеет смысл автоматически создавать адрес.
	 * В частности, для Amazon решил этого не делать,
	 * потому что автоматический адрес создаётся на основании геолокации, что не точно,
	 * а в случае с Amazon мы гарантированно можем получить точный адрес из профиля Amazon,
	 * поэтому нам нет никакого смысла забивать систему неточным автоматическим адресом.
	 * @override
	 * @used-by \Df\Customer\External\ReturnT::needCreateAddress()
	 * @used-by \Df\Customer\External\ReturnT::register()
	 * @return bool
	 */
	protected function needCreateAddress() {return false;}

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