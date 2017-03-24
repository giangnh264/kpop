<?php
return array(
    // autoloading model and component classes
    'import'=>array(
        'application.models.bm.*',
        'application.components.bm.*',
        'application.components.bm._base.*',
    ),

    'params' => array (
        'cmd.song.download'  => 'download_song',
        'cmd.song.listen'    => 'play_song',
        'cmd.video.download' => 'download_video',
        'cmd.video.play'	 => 'play_video',
        'cmd.subscribe'	 	 => 'subscribe',
        'cmd.subscribe_ext'  => 'subscribe_ext',
        'cmd.unsubscribe'	 => 'unsubscribe',
        'cmd.album.play'    => 'play_album',


        'sms.sendMT' => array(
                'serviceNumber'   => '9234',
                'wappush.smsType' => '1',
                'text.smsType'    => '0',
                'charge'		  => '1',
                'freeCharge'	  => '0',
                'senderPhone'     => '9234',
            ),
        'vinaChargingGateway' => 'http://10.1.10.86:8080/billing/billing',
        'vinaChargingGatewayName' => 'CHACHAVAS',
        'vinaChargingGatewayUser' => 'chachavas',
        'vinaChargingGatewayPassword' => 'chachaptdv123',
        'chargingGateway' => 'http://10.1.10.86:8080/ccgw/billing',
        'chargingName' => 'CHACHAVAS',
        'chargingUser' => 'chachavas',
        'chargingPassword' => 'chachaptdv123',
        'vinaChargingGateway' => 'http://10.1.10.86:8080/billing/billing',

    	// Charging MusicGift
    	'MSGIFT_chargingGateway' => 'http://10.1.10.86:8080/billing/billing',
    	//'MSGIFT_chargingGateway' => 'http://bm.chacha_cloud.com/billingsimulator',
    	'MSGIFT_chargingName' => 'MUSICGIFTVEGA',
    	'MSGIFT_chargingUser' => 'musicvega',
    	'MSGIFT_chargingPassword' => 'musicvega#vegamusic',


        'serviceNumber' => 9234,
        'numExpireDays' => 10,
        'VNGenre' => 60,
        'numSongDlChacha9' => 5,
    ),
);
?>
