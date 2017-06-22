<?php

namespace yii2lab\error\helpers;

use yii\helpers\Inflector;

class MessageHelper
{
	
	private function load($exception) {
		$translateKey = $exception->statusCode ?: $exception->getName();
		$translateKey = Inflector::variablize($translateKey);
		$translateKey = Inflector::underscore($translateKey);
		$translate = t('error/main', $translateKey);
		if(empty($translate) || ! is_array($translate)) {
			$translate = [];
		}
		if(YII_ENV_PROD && !empty($translate) && empty($translate['message'])) {
			$translate['message'] = t('this/main', 'error_for_production');
		}
		$translate['title'] = $translate['title'] ?: $exception->getName();
		$translate['message'] = $translate['message'] ?: $exception->getMessage();
		if(YII_ENV_DEV) {
			$translate['title'] .= ' (#' . $translateKey . ')';
		}
		return $translate;
	}
	
	function get($exception) {
		$translate = self::load($exception);
		//$translate['title'] = mb_ucfirst($translate['title']);
		//$translate['message'] = mb_ucfirst($translate['message']);
		$translate['message'] = str_replace('. ', '.<br/>',$translate['message']);
		return $translate;
	}
	
}
