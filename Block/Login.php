<?php
namespace Dfe\LPA\Block;
use Dfe\LPA\Settings as S;
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
	public function toHtml() {return !S::s()->enable() ? '' : parent::toHtml();}
}


