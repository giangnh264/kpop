<?php
return CMap::mergeArray(
                CMap::mergeArray(require(dirname(__FILE__) . '/errorConstants.php'), require(dirname(__FILE__) . '/sms_wap.php')), CMap::mergeArray(require(dirname(__FILE__) . '/main.php'), array(
                    'id' => 'bm',
                    'name' => 'Business model',
                    'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "bm",
                    //'viewPath'			=>	_APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "admin",
                    'defaultController' => 'bm',
                    // autoloading model and component classes
                    'import' => array(
                        'application.models.bm.*',
                        'application.components.bm.*',
                        'application.components.bm._base.*',
                        'application.components.bm.sms.*',
                    ),
                    // application components
                    'components' => array(
                        'request' => array(
                            'class' => 'application.components.common.HttpRequest',
                            'enableCsrfValidation' => false,
                        ),
                        'errorHandler' => array(
                            'errorAction' => '/default/error',
                        ),
                        "urlManager" => array(
		                    "urlFormat" => "path",
		                    "rules" => array(
		                    ),
		                    //"urlSuffix"=>".wsdl",
                        	'showScriptName' => false,
		                ),
		                'log'=>array(
                            'class'=>'CLogRouter',
                            'routes'=>array(
                                array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'error',
                                ),
                                array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'userActivity',
                                    'logFile'=>'userActivity.'.date('Ymd').'.log',
                                    'maxFileSize' => '50000',
                                ),
                                array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'sendMT',
                                    'logFile'=>'sendMT.'.date('Ymd').'.log',
                                    'maxFileSize' => '50000',
                                ),
                                array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'Charging',
                                    'logFile'=>'Charging.'.date('Ymd').'.log',
                                    'maxFileSize' => '50000',
                                ),
                                array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'userSubscribe',
                                    'logFile'=>'userSubscribe.'.date('Ymd').'.log',
                                    'maxFileSize' => '50000',
                                ),
                                array(
                                    'class' => 'application.components.bm.FileLogRouter',
                                    'levels' => 'exhibition',
                                    'logFile' => 'exhibition.' . date('Ymd') . '.log',
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
                                    'levels'=>'MUSICGIFT',
                                    'logFile'=>'MUSICGIFT.'.date('Ymd').'.log',
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
								array(
                                    'class'=>'application.components.bm.FileLogRouter',
                                    'levels'=>'VASPROVISIONING',
                                    'logFile'=>'VASPROVISIONING.'.date('Ymd').'.log',
                                    'maxFileSize' => '50000',
                                ),
                            ),
						),
                    ),
                    // modules

                    'params' => array(
                        'cmd.song.download' => 'download_song',
                        'cmd.song.listen' => 'play_song',
                        'cmd.song.gift' => 'gift_song',
                        'cmd.video.download' => 'download_video',
                        'cmd.video.play' => 'play_video',
                        'cmd.subscribe' => 'subscribe',
                        'cmd.subscribe_ext' => 'subscribe_ext',
                        'cmd.unsubscribe' => 'unsubscribe',
                        'cmd.album.play' => 'play_album',
                        'cmd.ringtone.download' => 'download_ringtone',
                        'cmd.rbt.download' => 'download_rbt',
                        'cmd.rbt.send' => 'send_rbt',
                    	'songGiftPrice'=>'5000',

                        'userSubscribe.active.status' => 1,
                        'lastTimeActivity' => 24, //24 hour
                        // for Bussiness
                        'promotion.package.price' => 0,
                        'promotion.song.price' => 0,
                        'promotion.video.price' => 0,
                        'source' => array(
                            '0' => 'wap',
                            '1' => 'web',
                            '2' => 'api',
                            '3' => 'sms',
                        ),

                        'sms.sendMT' => array(
                            'serviceNumber' => '9166',
                            'wappush.smsType' => '1',
                            'text.smsType' => '0',
                            'charge' => '1',
                            'freeCharge' => '0',
                            'senderPhone' => '9234',
                        ),
                    ),
                        )
                )
);
