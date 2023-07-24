<?php
namespace Dfe\Amazon\FE;
# 2016-05-30
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class JsOrigin extends \Df\Framework\Form\Element\Url {
	/**
	 * 2016-05-31
	 * @override
	 * @see \Df\Framework\Form\Element\Url::url()   
	 * @used-by \Df\Framework\Form\Element\Url::messageForOthers()
	 */
	final protected function url():string {return df_url_base(df_url_frontend('', [
		'_secure' => $this->requireHttps() ? true : null
	]));}
}