<?php
namespace Dfe\LPA;
use Dfe\LPA\Settings as S;
class I {
	/** @return string */
	public static function init() {
		static $r; return $r || !S::s()->enable() ? '' : $r = df_block_r(null, [], 'Dfe_LPA::init');
	}
}

