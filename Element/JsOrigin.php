<?php
namespace Df\Amazon\Element;
// 2016-05-30
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
	protected function url() {
		if (!isset($this->{__METHOD__})) {
			$this->{__METHOD__} = df_url_strip_path(parent::url());
		}
		return $this->{__METHOD__};
	}

	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::urlForMyLocalPc()
	 * @used-by \Df\Framework\Form\Element\Url::url()
	 * @return string
	 */
	protected function urlForMyLocalPc() {return $this->urlForOthers();}
}