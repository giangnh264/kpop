<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    require(dirname(__FILE__) . '/local.php'),
    require(dirname(__FILE__) . '/mongo.php'),
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'sourceLanguage' => 'code',
        'language' => 'vi_vn',
        // preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
            'application.models.db._base.*',
            'application.models.db.*',
            'application.components.common.*',
            'application.vendors.utilities.*',
        ),
        // application components
        'components' => array(
            'gearman' => array(
                'class' => 'ext.gearman.Gearman',
                'servers' => array(
                    array('host' => '192.168.89.96', 'port' => 4730),
                ),
            ),
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => true,
                'class' => 'WebUser',
            ),
            "SEO"=>array(
                'class'=>'application.components.common.SEO'
            ),
            // enable URLs in path-format
            'urlManager' => array(
            ),
            /*'request' => array(
                'class' => 'application.components.common.HttpRequest',
                'enableCsrfValidation' => true,
            ),*/
            /* 'session' => array(
                'class' => 'system.web.CDbHttpSession',
                'connectionID' => 'db',
                'timeout' => 86400,
                'sessionName' => 'SOMEABSTRACT_PHPSESSID',
            ), */
        ),
        /* 'behaviors'=>array(
             'runEnd'=>array(
                 'class'=>'application.components.common.ApplicationConfigBehavior',
                 'enabled' => true,
             ),
         ),*/
        // module config
        'modules' => array(
        ),
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array(
            'htmlMetadata'=>array(
                'title'=>'Tin Tức âm nhạc Kpop',
                'description'=>'Thế Giới Kpop - Thông tin đầy đủ về các Kpop Idol MỚI NHẤT',
                'keywords'=>'Thế Giới Kpop - Thông tin đầy đủ về các Kpop Idol MỚI NHẤT - BTS - EXO - TWICE - BIGBANG - SNSD',
            ),
            'cacheTime' => 600,
            // this is used to support multi lanuages
            'languages' => array('en_us' => 'English', 'vi_vn' => 'Tiếng Việt'),
            'defaultLanguage' => 'vi_vn',
            'web.domain' => '',
            "phone.country.code" => "84",
            "phone.prefix" => array(
                "841" => 12,
                "849" => 11
            ),


        ),
    )
);
