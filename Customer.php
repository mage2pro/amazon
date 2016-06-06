<?php
namespace Dfe\LPA;
use Dfe\LPA\Settings as S;
use Dfe\LPA\Settings\Login\Credentials as C;
class Customer extends \Df\Customer\External\Customer {
	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\Customer::id()
	 * @used-by \Df\Customer\External\ReturnT::register()
	 * @return string|null
	 */
	public function id() {return $this->p('user_id');}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\Customer::nameFirst()
	 * @return string
	 */
	public function nameFirst() {return df_first($this->nameA());}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\Customer::nameLast()
	 * @return string
	 */
	public function nameLast() {return df_last($this->nameA());}

	/**
	 * 2016-06-04
	 * @used-by \Dfe\FacebookLogin\Controller\Index\Index::customerData()
	 * @return string
	 */
	public function nameFull() {return $this->p('name');}

	/**
	 * 2016-06-05
	 * Мы запрашиваем у посетителя разрешение на получение его почтового индекса здесь:
	 * https://code.dmitry-fedyuk.com/m2e/login-and-pay-with-amazon/blob/42dcb17/view/frontend/web/login.js#L211
	 * @used-by \Dfe\LPA\Controller\Login\Index::addressData()
	 * @return string|null
	 */
	public function postalCode() {return $this->p('postal_code');}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\Customer::validate()
	 * @used-by \Df\Customer\External\ReturnT::c()
	 * @return void
	 * @throws \Exception
	 */
	public function validate() {
		/**
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
		/** @var string|null $errorCode */
		$errorCode = df_request('error');
		if ($errorCode) {
			/** @var string|null $errorDescription */
			$errorDescription = df_request('error_description', $errorCode);
			df_error("[Login with Amazon]: «{$errorDescription}».");
		}
		/**
		 * 2016-06-04
		 * Проверка токена.
		 * «Once you receive an access token using the implicit grant,
		 * it is highly recommended that you verify the authenticity of the access token
		 * before you retrieve a customer profile using that token.
		 * If a malicious site can induce a user to login,
		 * they can take the valid access token they receive
		 * and use it to mimic an authorization response to your site.
		 * To verify a token, make a secure HTTP call to https://api.amazon.com/auth/O2/tokeninfo,
		 * passing the access token you wish to verify.
		 * You can specify the access token as a query parameter.»
		 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
		 *
		 * Ответ сервера:
		 * {
		     "iss":"https://www.amazon.com",
		     "user_id": "amznl.account.K2LI23KL2LK2",
		     "aud": "amznl.oa2-client.ASFWDFBRN",
		     "app_id": "amznl.application.436457DFHDH",
		     "exp": 3597,
		     "iat": l3ll280970,
		  }
		 * «Compare the aud value to the client_id you are using for your application.
		 * If they are different, the access token was not requested by your application,
		 * and you should not use the access token.»
		 */
		df_assert_eq(C::s()->id(), $this->response('auth/o2/tokeninfo', 'aud'));
	}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Customer\External\Customer::_email()
	 * @used-by \Df\Customer\External\Customer::email()
	 * @return string|null
	 */
	protected function _email() {return $this->p('email');}

	/**
	 * 2016-06-04
	 * @return string[]
	 */
	private function nameA() {
		if (!isset($this->{__METHOD__})) {
			$this->{__METHOD__} = explode(' ', $this->nameFull());
		}
		return $this->{__METHOD__};
	}

	/**
	 * 2016-06-04
	 * «Obtain Customer Profile Information»
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/obtain_customer_profile.html
	 * «Once the user grants your website access to their Amazon customer profile,
	 * you will receive an access token.
	 * If you're using the server-based Authorization Code Grant,
	 * the access token is returned in the access token response.
	 * If you're using the client-based Implicit grant,
	 * the access token is returned in the authorization response as a URI fragment.
	 * To access the authorized customer data,
	 * you submit that access token to Login with Amazon using HTTPS.
	 * In response, Login with Amazon will return the appropriate customer profile data.
	 * The profile data you receive is determined by the scope you specified when requesting access.
	 * The access token reflects access permission for that scope.»
	 *
	 * Раньше решение было таким:
		$client = new \Zend_Http_Client;
		$client->setUri($this->url('user/profile'));
		$client->setHeaders('Authorization', 'bearer ' . $token);
		$profile = df_json_decode($client->request()->getBody())
	 *
	 * Оказывается, мы не обязаны использовать заголовок HTTP «Authorization»,
	 * а можем вместо этого просто передать токен в URL:
	 * https://api.amazon.com/user/profile?access_token=AtzaIIQ...
	 * «If you are calling the Profile REST API directly,
	 * you can specify the access token in one of three ways:
	 * as a query parameter, as a bearer token, or using x-amz-access-token in the HTTP header.»
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/obtain_customer_profile.html
	 *
	 * 2016-06-03
		{
			"user_id": "amzn1.account.AGM6GZJB6GO42REKZDL33HG7GEJA",
			"name": "Jack London",
			"email": "test-customer@mage2.pro"
		}
	 * @var array(string => string) $profile
	 *
	 * 2016-06-04
	 * «Integrate with Your Existing Account System»
	 * https://login.amazon.com/documentation/combining-user-accounts
	 *
	 * «You will need to modify your account database
	 * to record a mapping between Amazon account identifiers and your local accounts.
	 * This could take the form of a new field in your account table
	 * or a table that maps between Amazon account identifiers and your local account identifiers.
	 * Amazon account identifiers are returned as the user_ID property,
	 * in the form amzn1.accountVALUE. For example: amzn1.account.K2LI23KL2LK2.»
	 *
	 * @param string $key
	 * @param string|null $default [optional]
	 * @return string|null
	 */
	private function p($key, $default = null) {return $this->response('user/profile', $key, $default);}

	/**
	 * 2016-06-04
	 * @param string $path
	 * @param string $key
	 * @param string|null $default [optional]
	 * @return array(string => string)
	 */
	private function response($path, $key, $default = null) {
		if (!isset($this->{__METHOD__}[$path])) {
			$this->{__METHOD__}[$path] = df_http_json($this->url($path));
		}
		return dfa($this->{__METHOD__}[$path], $key, $default);
	}

	/**
	 * 2016-06-04
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/access_token.html
	 * «After users log in, they are returned to your website or mobile app.
	 * At this point, your client can obtain an access token
	 * by calling the Login with Amazon authorization service.
	 * That token allows clients to access the customer's name and email address
	 * from their customer profile.»
	 * «Access tokens are only valid for sixty minutes
	 * and are specific to the user logging in and the data the app requested
	 * when it triggered the login.»
	 *
	 * В принципе, при необходимости мы можем обменять полученный сейчас временный токен
	 * (который действителен 1 час) на безлимитный:
	 * «A refresh token allows a website to request a new access token,
	 * even if the access token has expired.
	 * Refresh tokens follow the same format as access tokens,
	 * except they begin with the string Atzr|.
	 * Refresh tokens are valid indefinitely,
	 * unless the user has removed the website or mobile app
	 * from the list of allowed apps for their account.
	 * Refresh tokens have a maximum size of 2048 bytes.
	 * A refresh token is specifically assigned to one client
	 * and cannot be used by another client.»
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/refresh_token.html
	 *
	 * Не, в данном конкретном случае получить refresh token не можем:
	 * «Refresh tokens are returned only in the Authorization Code Grant».
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/refresh_token.html
	 *
	 * Есть две технологии взаимодействия с сервером Amazon:
	 * «Authorization Code Grant» и «Implicit Grant», они чуть различаются
	 * серверной обработкой магазина:
	 * при «Implicit Grant» надо сделать один дополнительный запрос к API:
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/authorization_grants.html
	 * Мы используем «Implicit Grant», поэтому получить refresh token не можем.
	 * Ну не особо и надо.
	 *
	 * @return string
	 */
	private function token() {return df_request('access_token');}

	/**
	 * 2016-06-03
	 * @param string $path
	 * @return string
	 */
	private function url($path) {
		if (!isset($this->_urlBase)) {
			$this->_urlBase = df_cc_clean('.',
				'https://api', S::s()->test() ? 'sandbox' : null, 'amazon.com/'
			);
		}
		if (!isset($this->_urlQuery)) {
			$this->_urlQuery = '?' . http_build_query(['access_token' => $this->token()]);
		}
		return $this->_urlBase . $path . $this->_urlQuery;
	}

	/**
	 * 2016-06-04
	 * @var string
	 * @used-by \Dfe\LPA\Customer::url()
	 */
	private $_urlBase;

	/**
	 * 2016-06-04
	 * @var string
	 * @used-by \Dfe\LPA\Customer::url()
	 */
	private $_urlQuery;
}