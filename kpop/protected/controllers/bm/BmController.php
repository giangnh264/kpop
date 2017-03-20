<?php
class BmController extends CController {

    public function actions() {
        return array(
            'index' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string the code of song
     * @param string the from_phone of song
     * @param string the to_phone of song
     * @param string the source_type of song
     * @param integer promotion
     * @param string smsId
     * @param array noteOptions: more option from client
     * @return bmResult
     * @soap
     */
    public function downloadSong($code, $from_phone, $to_phone, $source_type, $promotion, $smsId = "", $noteOptions=array()) {
        $par = array(
            'itemCode' => $code,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'to_phone' => Formatter::formatPhone($to_phone),
            'source' => strtolower($source_type),
            'promotion' => $promotion,
            'smsId' => $smsId,
        	'noteOptions'=>	$noteOptions
        );

        $downloadSong = new DownloadSong($par);
        $result = $downloadSong->doDownloadSong();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }

    /**
     * @param string the code of song
     * @param string the from_phone of song
     * @param string the source_type of song
     * @param integer promotion
     * @param array noteOptions: more option from client
     * @return bmResult
     * @soap
     */
    public function playSong($code, $from_phone, $source_type, $promotion,$noteOptions=array()) {
        $par = array(
            'itemCode' => $code,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'source' => strtolower($source_type),
            'promotion' => $promotion,
        	'noteOptions'=>	$noteOptions
        );
        $playSong = new ListenSong($par);
        $result = $playSong->doListenSong();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }

    /**
     * @param string the code of song
     * @param string the from_phone of song
     * @param string the to_phone of song
     * @param string the record_filePath of song
     * @param integer the send_now of song
     * @param string the delivery_time of song
     * @param string the source_type of song
     * @param string smsId
     * @param string message
     * @return bmResult
     * @soap
     */
    public function giftSong($code, $from_phone, $to_phone, $record_filePath, $send_now, $delivery_time, $source_type="ivr", $smsId = "", $message = "") {
        $par = array(
            'itemCode' => $code,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'to_phone' => Formatter::formatPhone($to_phone),
            'source' => strtolower($source_type),
            'record_filePath' => $record_filePath,
            'send_now' => $send_now,
            'delivery_time' => $delivery_time,
            'smsId' => $smsId,
            'message' => $message
        );

        $giftSong = new GiftSong($par);
        $result = $giftSong->doGiftSong();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }

    /**
     * @param string the code of video
     * @param string the from_phone of video
     * @param string the to_phone of video
     * @param string the source_type of video
     * @param integer the promotion of video
     * @param string the smsId of video
     * @param array the noteOptions more option from client
     * @return bmResult
     * @soap
     */
    public function downloadVideo($code, $from_phone, $to_phone, $source_type, $promotion, $smsId = "", $noteOptions = array()) {
        $from_phone = $from_phone;
        $to_phone = $to_phone;
        $par = array(
            'itemCode' => $code,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'to_phone' => Formatter::formatPhone($to_phone),
            'source' => strtolower($source_type),
            'promotion' => $promotion,
            'smsId' => $smsId,
        	'noteOptions'=>	$noteOptions
        );


        $downloadVideo = new DownloadVideo($par);
        $result = $downloadVideo->doDownloadVideo();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }

    /**
     * @param string the code of video
     * @param string the from_phone of video
     * @param string the source_type of video
     * @param integer promotion
     * @param array noteOptions: more option from client
     * @return bmResult
     * @soap
     */
    public function playVideo($code, $from_phone, $source_type, $promotion,  $noteOptions=array()) {
        $par = array(
            'itemCode' => $code,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'source' => strtolower($source_type),
            'promotion' => $promotion,
        	'noteOptions'=>	$noteOptions
        );

        $watchVideo = new WatchVideo($par);
        $result = $watchVideo->doWatchVideo();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }

    /**
     * @param string the user_phone of user
     * @param string the package user register
     * @param string the source channel of user register
     * @param string promotion = 0, Nc, Nd, Nw, Nm
     * @param int bundle= 0 - DK goi cuoc binh thuong, 1 - DK goi kieu bundle (neu bundle=1 thi note_event=bundle_code)
     * @param string smsId
     * @param string note_event
	 * @param array options: more option from client
	 *		- send_sms: 1 - send, 0 - not send
	 *		- channel: usign to send to charging if source is vinaphone
     * @return bmResult
     * @soap
     */
    public function userRegister($user_phone, $package, $channel="", $promotion="0", $bundle=0, $smsId = "", $note_event='', $options=array()) {
        $par = array(
            'msisdn' => Formatter::formatPhone($user_phone),
            'itemCode' => $package,
            'source' => strtolower($channel),
            'promotion' => $promotion,
            'bundle' => $bundle,
            'smsId' => $smsId,
        	'note_event' => $note_event
        );

		if(!empty($options)) $par['client_options'] = $options;

        $sub = new Subscribe($par);
        $result = $sub->doSubscribe();

        $res = new stdClass();
        $res->errorCode = $result['error'];
        $res->message = $result['message'];
        return $res;
    }

    /**
     * @param int the user_id of user
     * @param string the user_phone of user
     * @param string the source
     * @param string package code
	 * @param string smsId
	 * @param array options: more option from client
	 *		- send_sms: 1 - send, 0 - not send
	 *		- channel: usign to send to charging if source is vinaphone
     * @return bmResult
     * @soap
     */
    public function userUnRegister($user_id, $user_phone, $package, $source_type, $smsId = "", $options=array()) {
        $par = array(
            'userId'	=> $user_id,
            'msisdn'	=> Formatter::formatPhone($user_phone),
			'package'	=> $package,
            'source'	=> strtolower($source_type),
            'smsId'		=> $smsId
        );

		if(!empty($options)) $par['client_options'] = $options;

		$unsub = new Unsubscribe($par);
        $result = $unsub->doUnsubscribe();

        $res = new stdClass();
        $res->errorCode = $result['error'];
        $res->message = $result['message'];
        return $res;
    }

    /**
     * @param string the id of album
     * @param string the from_phone of song
     * @param string the source_type of song
     * @param integer promotion
     * @return bmResult
     * @soap
     */
    public function playAlbum($id, $from_phone, $source_type, $promotion) {
        $par = array(
            'itemCode' => $id,
            'msisdn' => Formatter::formatPhone($from_phone), // user phone
            'source' => strtolower($source_type),
            'promotion' => $promotion
        );
        $playAlbum = new PlayAlbum($par);
        $result = $playAlbum->doPlayAlbum();

        $res = new stdClass();
        $res->errorCode = Yii::app()->params['errorConstant'][$result['error']];
        if (!isset($res->errorCode)) {
            $res->errorCode = 404;
        }
        $res->message = $result['error'];
        return $res;
    }
    
    /**
     * @param array parametes
     * @return bmResult
     * @soap
     */    
    public function charging($parameters = array())
    {
    	$res = new stdClass();
    
    	if(empty($parameters)){
    		$res->errorCode = 500;
    		$res->message = "Missing params";
    	} else{
    		if(!isset($parameters["msisdn"]) || !isset($parameters["price"]) || !isset($parameters["cmd"])){
    			$res->errorCode = 500;
    			$res->message = "Missing params".json_encode($parameters);
    		}else{
    			// DO CHARG
    			$charge = new Charging($parameters);
    			$res = $charge->doCharg();
    		}
    	}
    	return $res;
    }
        
    /**
     * @param string the username
     * @param string the msisdn
     * @return bmResult
     * @soap
     */
    public function testSoap($username,$msisdn) {
    
    	$res = new stdClass();
    	$res->errorCode = 0;
    	$res->message = "Success-".$username."---".$msisdn;
    	$res->data= $username."---".$msisdn;
    	return $res;
    }

}

class bmResult {

    /**
     * @var string $errorCode
     * @soap
     */
    public $errorCode;

    /**
     * @var string $message
     * @soap
     */
    public $message;

}