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
			'connectionString' => 'mysql:host=localhost;dbname=dashboard',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            'attributes'=>array(
			PDO::MYSQL_ATTR_LOCAL_INFILE => true,
		  ),
		),
	'msdb'=>array( // microsoft sql server connection
	 'class' => 'CDbConnection',
	 'connectionString' => 'sqlsrv:Server=RDL-APP1; Database=Evolution',
	 //'connectionString' => 'mssql:Server=RDL-APP1; Database=Evolution',
	 //'connectionString' => 'odbc:Driver=mssql; Server=RDL-APP1; port= Database=Evolution; UID=artakm; PWD=Simplicity5',
	 //'connectionString' => 'odbc:Driver={SQL Server Native Client 11};Server={RDL-APP1};Database={Evolution};',
	 //ConnectionString="Driver={SQLServer};Server=your_server_name;" &_"Database=your_database_name;Uid=your_username;Pwd=your_password;" ,
	 'username' => 'dashboard',
	 'password' => 'Protocol5',
	 'charset' => 'GB2312',
    //'tablePrefix' => 'tbl',
    //'emulatePrepare' =>false
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

