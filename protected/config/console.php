<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cron',

	// preloading 'log' component
	'preload'=>array('log'),
    
    'import'=>array(
        'application.components.*',
        'application.models.*',
    ),

	// application components
	'components'=>array(

		// uncomment the following to use a MySQL database
		
	'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=verare',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            'attributes'=>array(
			PDO::MYSQL_ATTR_LOCAL_INFILE => true,
		  ),
		),
		
		'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
	),
    
);

