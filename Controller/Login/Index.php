<?php
namespace Dfe\LPA\Controller\Login;
use Dfe\LPA\Settings as S;
use Dfe\LPA\Settings\Login\Credentials as C;
class Index extends \Magento\Framework\App\Action\Action {
	/**
	 * 2016-06-03
	 * «Obtaining profile information»
	 * https://payments.amazon.com/documentation/lpwa/201953190#button_widget_php
	 * @override
	 * @see \Magento\Framework\App\Action\Action::execute()
	 * @return \Magento\Framework\Controller\Result\Redirect
	 */
	public function execute() {return df_leh(function() {
		/** @var string|null $token */
		$token = df_request('access_token');
		/** @var array(string => string) $tokenInfo */
		$tokenInfo = df_http_json($this->url('auth/o2/tokeninfo'), ['access_token' => $token]);
		df_assert_eq(C::s()->id(), dfa($tokenInfo, 'aud'));
		/** @var \Zend_Http_Client $client */
		$client = new \Zend_Http_Client;
		$client->setUri($this->url('user/profile'));
		$client->setHeaders('Authorization', 'bearer ' . $token);
		/**
		 * 2016-06-03
			{
				"user_id": "amzn1.account.AGM6GZJB6GO42REKZDL33HG7GEJA",
				"name": "Jack London",
				"email": "test-customer@mage2.pro"
			}
		 * @var array(string => string) $profile
		 */
		$profile = df_json_decode($client->request()->getBody());
		df_log($profile);
	});}

	/**
	 * 2016-06-03
	 * @param string $path
	 * @return string
	 */
	private function url($path) {
		if (!isset($this->{__METHOD__})) {
			$this->{__METHOD__} = df_cc_clean('.',
				'https://api', S::s()->test() ? 'sandbox' : null, 'amazon.com/'
			);
		}
		return $this->{__METHOD__} . $path;
	}
}