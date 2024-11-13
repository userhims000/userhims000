<?php

namespace WPCWV;
if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}

interface StrategyInterface{
	public function rewriteOutput($dom);
}