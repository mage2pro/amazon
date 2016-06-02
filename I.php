<?php
namespace Dfe\LPA;
use Dfe\LPA\Settings as S;
// 2016-06-02
class I {
	/**
	 * 2016-06-02
	 * Сделал по аналогии с @see \Df\Facebook\I::init()
	 * @return string
	 */
	public static function init() {
		static $r; return $r || !S::s()->enable() ? '' : $r = df_block_r(null, [], 'Dfe_LPA::init');
	}
}

