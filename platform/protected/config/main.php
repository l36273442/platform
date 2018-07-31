<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'platform',
    'language'=>'zh_cn',
    'sourceLanguage'=>'zh_cn',
    // preloading 'log' component
	'preload'=>array('log','platfrom'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.service.*',
		'application.controllers.*',
	),

	'defaultController'=>'site',
    //自定义模块
    'modules'=>array(
        'admin',
    ),
	// application components
    'components'=>array(
        'session'=>array(
            'timeout'=>1800,
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'db'=> require dirname(__FILE__).'/db.'.ENV.'.php',
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
            'urlFormat'=>'path',
            //'urlSuffix'=>'.html',
            'rules'=>array(
                '' => 'site/index',
                'signin' => 'login/signin',
                'signup' => 'register/signup',
                'logout' => 'userview/logout',
                'invite' => 'userview/invite',
                'withdraw' => 'userview/withdraw',
                'address' => 'userview/address',
                'about' => 'site/about',
                'help' => 'site/help',
                'mines' => 'mines/index',
                'userpanel' => 'userview/panel',
                'millassets' => 'userview/machineassets',
                'hashassets' => 'userview/powerassets',
                'hashshop' => 'powercontractview/hashshop',  
                'millshop' => 'machinecontractview/millshop',  
                'hashdetail' => 'powercontractview/hashdetail',  
                'milldetail' => 'machinecontractview/milldetail',  
                'resetpassword' => 'login/resetpassword',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
        ),
        'log'=>require dirname(__FILE__).'/log.php',
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	//'params'=>require(dirname(__FILE__).'/params.php'),
);
