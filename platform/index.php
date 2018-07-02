<?php

// include Yii bootstrap file
define( 'ENV', 'test' );
require_once(dirname(__FILE__).'/protected/config/define.'.ENV.'.php');
require_once(dirname(__FILE__).'/../framework/yii.php');
require_once(dirname(__FILE__).'/protected/components/Controller.php');
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

// create a Web application instance and run
Yii::createWebApplication($config)->run();
