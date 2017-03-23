<?php
return array(
    'components' => array(
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=kpop',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'class' => 'CDbConnection',
            'enableProfiling' => false,
            'enableParamLogging' => false,
            'schemaCachingDuration' => 3600,
        ),

        /*'cache' => array(
            'class' => 'system.caching.CMemCache',
            'servers' => array(
                array('host' => '192.168.158.43', 'port' => 11211),
            ),
        ),*/
    ),
    'params' => array(
        'local_mode' => 1,
        'base_url' => 'http://104.199.237.187',
        'crbt' => array(
            'url' => 'http://113.187.31.231:8080/spservice/',
            'sid' => '589002',
            'seq' => '5890022015112133194300000000',
            'sidpwd' => '38628bf16f30158a0dfdc34902e1febf',
            'modulecode' => '589002',
        ),

        'smsClient' => array(
            // 'smsWsdl'=>'http://192.168.1.243:8080/api/soap',
            'smsWsdl' => 'http://192.168.241.67:8080/api/soap',
            'username' => 'chacha1',
            'password' => '123chacha456',
            'serviceName' => 'IMUZIK',
        ),
        'storage' => array(
            'staticDir' => _APP_PATH_,
            'staticUrl' => 'http://static.amusic.vn',
            'baseStorage' => '/u01/storage/amusic/',

            'NewsDir' => '/var/www/static/img',
            'NewsUrl' => 'http://104.199.237.187:8080/img/',

        ),


        // bm
        'bmConfig' => array(
            # 'remote_wsdl'		=> 'http://192.1i68.241.31:8081',
            'remote_wsdl' => 'http://bm.amusic.lc',
            'remote_username' => 'chacha',
            'remote_password' => 'chacha',
        ),

        // solr search
        'solr.server.host' => 'localhost',
        'solr.server.port' => 8983,
        'solr.server.path' => '/solr/',
    )
);
?>
