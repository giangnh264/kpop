<?php
include_once '../../cons.php';

@ini_set('memory_limit', "512M");
@ini_set('session.name', 'ADMIN');
ini_set('session.cookie_domain', '.ovp.vn' );

@ini_set("max_execution_time", 86400);
@ini_set('session.gc_maxlifetime', 60*60*24);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');


defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_DEBUG') or define('YII_DEBUG',TRUE);

$config=_APP_PATH_.'/protected/config/admin_dev.php';
require_once($yii);
Yii::createWebApplication($config)->run();