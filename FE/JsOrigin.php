<?php
namespace Df\Amazon\FE;
// 2016-05-30
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class JsOrigin extends \Df\Framework\Form\Element\Url {
	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::url()   
	 * @used-by \Df\Framework\Form\Element\Url::messageForOthers()
	 * @return string
	 */
	final protected function url() {return df_url_base(parent::url());}
}