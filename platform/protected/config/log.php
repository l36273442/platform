<?php
define('YII_LOG_DATE', date('Ymd'));
return array(
    'class'=>'CLogRouter',
    'routes'=>array(
        //system error log
        array(
            'class'         => 'CFileLogRoute',
            'levels'        => 'error, warning',
            'logFile'       => 'system_error.' . YII_LOG_DATE . '.log',
            'logPath'       => SYSTEM_LOG_PATH,
            'maxFileSize'   => 10485760, //1G
        ),
        array(
            'class'         => 'CProfileLogRoute',
            'levels'        => 'error, warning,info,trace,profile',
        ),
    ),
);
