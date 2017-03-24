<?php
return CMap::mergeArray(
		CMap::mergeArray(CMap::mergeArray(require(dirname(__FILE__) . "/main.php"), require(dirname(__FILE__) . "/console_bm.php")),require(dirname(__FILE__) . "/sms_wap.php")), 
		array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Chacha Console',
        'import'=>array(
            'application.models.db.*',
            'application.components.common.*',
            'application.extensions.yii-mail.*',
            'application.vendors.utilities.*',
            'application.vendors.fundial_8xxx.*',
        ),
        'components'=>array(
			'session' => array(
            	'class'=>'CHttpSession',
		    ),

            'mail' => array(
                'class' => 'application.extensions.yii-mail.YiiMail',
                'transportType'=>'smtp', /// case sensitive!
                'transportOptions'=>array(
                    'host'=>'smtp.gmail.com',
                    'username'=>'star.chacha.vn@gmail.com',
                    'password'=>'D@nTrj09##',
                    'port'=>'465',
                    'encryption'=>'ssl',
                    ),
                'viewPath' => 'application.views.mail',
                'logging' => true,
                'dryRun' => false
            ),

            // log
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'logFile'=>'migrate.log',
                        'categories'=>'migrate.*',
                    ),
                    array(
                        'class'=>'CFileLogRoute',
                        'logFile'=>'sync.log',
                        'categories'=>'sync.*',
                    ),
                    array(
                        'class'=>'CFileLogRoute',
                        'logFile'=>'merge.log',
                        'categories'=>'merge.*',
                    ),
                    array(
                        'class'=>'application.components.bm.FileLogRouter',
                        'levels'=>'Charging',
                        'logFile'=>'Charging.'.date('Ymd').'.log',
                        'maxFileSize' => '50000',
                    ),
                    array(
                        'class'=>'application.components.bm.FileLogRouter',
                        'levels'=>'subscribeExtend',
                        'logFile'=>'subscribeExtend.'.date('Ymd').'.log',
                        'maxFileSize' => '50000',
                    ),
					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'SUBSCRIBER_REQUEST',
						'logFile'=>'SUBSCRIBER_REQUEST.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),
					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'SUBSCRIBER_RESPONSE',
						'logFile'=>'SUBSCRIBER_RESPONSE.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),
					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'CDR',
						'logFile'=>'CDR.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),
					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'CONTENT',
						'logFile'=>'CONTENT.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),
					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'BM_ERROR',
						'logFile'=>'ERROR.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),

					array(
						'class'=>'application.components.bm.FileLogRouter',
						'levels'=>'CDR_FAILED',
						'logFile'=>'CDR_FAILED.'.date('Ymd').'.log',
						'maxFileSize' => '50000',
					),

                    // log SQL
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error',
                        'categories' => 'system.db.CDbCommand',
                        'logFile' => 'db.log',
                    ),
                ),
            ),
        ),

        'params' => array(
        	'cp_limit_content' => 49999,
			'voucher' => array(
				'VOUCHER_2013' => 'Xin cam on QK'
			)
        ),
    )
);
?>
