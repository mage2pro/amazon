<?php
namespace Df\Amazon\Element;
/**
 * 2016-05-30
 * @final We are unable to specify it explicitly with the «final» PHP keyword
 * because Magento 2 will autogenerate a subclass:
 * https://github.com/magento/devdocs/blob/713b78a/guides/v2.0/extension-dev-guide/code-generation.md#when-is-code-generated
 */
class JsOrigin extends \Df\Framework\Form\Element\Url {
	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::messageForThirdPartyLocalhost()
	 * @used-by \Df\Framework\Form\Element\Url::getElementHtml()
	 * @return string
	 */
	protected function messageForThirdPartyLocalhost() {return $this->messageForOthers();}

	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::url()
	 * @return string
	 */
	protected function url() {return dfc($this, function() {return df_url_base(parent::url());});}

	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::urlForMyLocalPc()
	 * @used-by \Df\Framework\Form\Element\Url::url()
	 * @return string
	 */
	protected function urlForMyLocalPc() {return $this->urlForOthers();}
}