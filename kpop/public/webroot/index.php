<?php
//session_start();
include_once '../../cons.php';

defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

ini_set('session.name', 'WEB');
$config=_APP_PATH_.'/protected/config/web.php';
require_once($yii);
Yii::createWebApplication($config)->run();