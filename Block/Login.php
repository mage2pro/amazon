<?php
namespace Dfe\LPA\Block;
/**
 * 2016-06-02
 * «Login with Amazon» button
 */
class Login extends \Magento\Framework\View\Element\Html\Link {
	/**
	 * 2016-06-02
	 * @override
	 * @see \Magento\Framework\View\Element\Html\Link::toHtml()
	 * @return string
	 */
	public function toHtml() {return parent::toHtml();}

	/**
	 * 2016-06-02
	 * @return void
	 */
	public static function init() {}
}


