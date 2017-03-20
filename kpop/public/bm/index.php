<?php
include_once '../../cons.php';

/*$allowedIps = array(
		//VPN
		'10.6.0.22','172.16.100.30',
		//Internet
		'118.70.124.143',
		//local
		'127.0.0.1','::1','172.16.100.1','10.0.0.83',
);
if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIps))
{
	die('Invailid IP:'.$_SERVER['REMOTE_ADDR']);
}*/


defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_DEBUG') or define('YII_DEBUG',FALSE);

$config=_APP_PATH_.'/protected/config/bm.php';
require_once($yii);
Yii::createWebApplication($config)->run();
