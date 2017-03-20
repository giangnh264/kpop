<?php
include_once '../../cons.php';

@ini_set('memory_limit', "512M");
@ini_set('session.name', 'ADMIN');
//ini_set('session.cookie_domain', '.ovp.vn' );

@ini_set("max_execution_time", 86400);
@ini_set('session.gc_maxlifetime', 60*60*24);

defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_DEBUG') or define('YII_DEBUG',FALSE);

$config=_APP_PATH_.'/protected/config/admin.php';
require_once($yii);
Yii::createWebApplication($config)->run();