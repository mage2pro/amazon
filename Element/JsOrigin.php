<?php
namespace Df\Amazon\Element;
// 2016-05-30
/** @final Unable to use the PHP «final» keyword because of the M2 code generation. */
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