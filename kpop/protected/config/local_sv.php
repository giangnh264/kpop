<?php
return array(
    'runtimePath' => "/home/dev/runtime",
    'components' => array(
        'log' => array(
            'class' => '  CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            ),
        ),
        'db' => array(
            //'connectionString' => 'mysql:host=192.168.89.71;dbname=amusic',
            'connectionString' => 'mysql:host=192.168.89.120;dbname=amusic',
            'emulatePrepare' => true,
            'username' => 'amusic',
            'password' => 't93dLhtl9426Hqm',
            'charset' => 'utf8',
            'class' => 'CDbConnection',
            'enableProfiling' => false,
            'enableParamLogging' => false,
            'schemaCachingDuration' => 3600,
        ),

        'cache' => array(
            'class' => 'system.caching.CMemCache',
            'servers' => array(
                array('host' => '192.168.89.188', 'port' => 11211),
            ),
        ),
    ),
    'params' => array(
        'local_mode' => 0,
        'base_url' => 'http://amusic.vn/',
        'price' => array(
            'songListen' => '1000',
            'songDownload' => '2000',
            'videoListen' => '2000',
            'videoDownload' => '3000',
            'rtDownload' => '2000',
            'albumListen' => '4000',
            'songGiftListen' => '600'
        ),
        'smsClient' => array(
            'smsWsdl' => 'http://192.168.89.194:8084/api/soap',
            // 'smsWsdl'=>'http://192.168.89.94:8084/api/soap',
            'username' => 'amusic',
            'password' => 'amusic_2015@!',
            'serviceName' => 'AMUSIC',
            'serviceNumber' => '9166',
        ),
        'charging_proxy' => array(
            'url' => 'http://192.168.89.194:9999/ws/chargingRequest?wsdl',
            'username' => 'vega',
            'password' => 'vega.123'
        ),
        'crbt' => array(
            'url' => 'http://113.187.31.231:8080/spservice/',
            'sid' => '589002',
            'seq' => '5890022015112133194300000000',
            'sidpwd' => '73461e20eca29f3279830a9c25df16af',
            'modulecode' => '589002',
        ),

        'freedata' => array(
            'url' => 'http://192.168.89.94:8081/Billingsimulator',
            'user' => 'Amusic',
            'pass' => 'Amusic@123',
            'cp_id' => '001',
            'sp_id' => '001',
            'shortcode' => '049166',
            'service_name' => 'SOG_AMUSIC',
            'content_id' => "0000000001",
        ),

        'storage' => array(
            'staticDir' => _APP_PATH_,
            'staticUrl' => 'http://static.amusic.vn',
            'baseStorage' => '/u01/storage/amusic/',

            'albumDir' => '/u01/storage/amusic/albums',
            'albumUrl' => 'http://static.amusic.vn/amusic/albums/',
            'albumUrl3Gp' => '',
            'albumUrlMp3' => '',

            'artistDir' => '/u01/storage/amusic/artists/',
            'artistUrl' => 'http://static.amusic.vn/amusic/artists/',

            'songDir' => '/u01/storage/amusic/songs',
            'songUrl' => 'http://streaming.amusic.vn/amusic/',
            'songUrlRTSP' => 'http://streaming.amusic.vn/amusic/',
            'songUrlDownload' => 'http://download.amusic.vn/amusic/',
            'songUrlRTSPDownload' => 'http://download.amusic.vn/amusic/',

            'userDir' => '/u01/storage/amusic/users/',
            'userUrl' => 'http://static.amusic.vn/amusic/users/',

            'videoDir' => '/u01/storage/amusic/videos/',
            'videoUrl' => 'http://streaming.amusic.vn/amusic/',
            'videoUrlRTSP' => 'http://streaming.amusic.vn/amusic/',
            'videoImageUrl' => 'http://static.amusic.vn/amusic/videos/',

            'videoPlaylistUrl' => 'http://static.amusic.vn/amusic//videoplaylist/',
            'videoPlaylistDir' => '/u01/storage/amusic/videoplaylist',

            'newsDir' => '/u01/storage/amusic/news',
            'newsUrl' => 'http://static.amusic.vn/amusic/news/',

            'playlistDir' => '/u01/storage/amusic/playlist',
            'playlistUrl' => 'http://static.amusic.vn/amusic/playlist/',

            'ringtoneDir' => '/u01/storage/amusic/ringtones',
            'ringtoneUrl' => 'http://static.amusic.vn/ringtones/',
            'rbtDir' => '/u01/storage/amusic/rbt',
            'rbtUrl' => 'http://static.amusic.vn/rbt/output/',

            'radioDir' => '/u01/storage/amusic/radio/icons',
            'radioUrl' => 'http://static.amusic.vn/amusic/radio/icons/',
            'newsEventDir' => '/u01/storage/amusic/event',

            'newsEventUrl' => 'http://static.amusic.vn/amusic/event/',
            'bannerDir' => '/u01/storage/amusic/banner',
            'bannerUrl' => 'http://static.amusic.vn/amusic/banner/',
            'topContentDir' => '/u01/storage/amusic/topcontent',
            'topContentUrl' => 'http://static.amusic.vn/amusic/topcontent/',
        ),

        // bm
        'bmConfig' => array(
            # 'remote_wsdl'          => 'http://192.1i68.241.31:8081',
            'remote_wsdl' => 'http://192.168.89.94:8081',
            'remote_username' => 'amusic',
            'remote_password' => 'p5fatDVCvBAvwuO',
        ),

        // solr search
        'solr.server.host' => '127.0.0.1',
        'solr.server.port' => 8983,
        'solr.server.path' => '/solr/',
    )
);
?>
