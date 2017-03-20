<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/console.php'),
    array(
    		'commandPath' => dirname(__FILE__) . '/../commands/services/',
    		'components'=>array(
    				// log
    				'log'=>array(
    						'class'=>'CLogRouter',
    						'routes'=>array(
    								array(
    										'class'=>'application.components.encode.FileLogRouter',
    										'categories'=>'ENCODE_REQUEST.*',
    										'levels'=>'error, trace',
    										'logFile'=>'ENCODE_REQUEST.'.date('Ymd').'.log',
    										'maxFileSize' => '50000',
    								),
    						),
    				),
				'user' => array(
					// enable cookie-based authentication
					'allowAutoLogin' => true,
					'class' => 'WebUser',
				),
    		),
    )
)

?>

