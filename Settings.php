<?php
namespace Dfe\LPA;
use Magento\Framework\App\ScopeInterface as S;
class Settings extends \Df\Core\Settings {
	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


