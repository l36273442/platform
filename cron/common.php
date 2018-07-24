<?php
set_time_limit(0);
define( 'ENV', 'test' );
$db_config = require(dirname(__FILE__).'/../platform/protected/config/db.'.ENV.'.php'); 
require(dirname(__FILE__).'/../platform/protected/config/define.'.ENV.'.php'); 
try {
$db = new PDO( $db_config['connectionString'].';charset=UTF8', $db_config['username'], $db_config['password']);
}catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage(),"\n";
    exit;
}
