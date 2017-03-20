<?php

class SmsController extends CController {

    public function actions() {
        return array(
            'index' => array(
                'class' => 'CWebServiceAction',
                'classMap' => array(
                ),
            ),
        );
    }

    /**
     * @param receiveMoRequestType $parametes
     * @return string
     * @soap
     */
    public function receiveMO($parameters = array()) {
        $username = $parameters->username;
        $password = $parameters->password;
        $service_number = $parameters->service_number;
        $sender = Formatter::formatPhone($parameters->sender);
        $content = $parameters->content;
        $keyword = $parameters->keyword;
        $first_param = $parameters->first_param;
        $last_param = $parameters->last_param;
        $sms_id = $parameters->sms_id;
        $smsc = $parameters->smsc;
        $keyword = strtoupper($keyword);
        $smsMo = LogSmsMoModel::model()->logMo($username, $password, $service_number, $sender, $content, $keyword, $first_param, $last_param, $sms_id, $smsc);
        $func = SmsKeywordModel::model()->findByAttributes(array("sms_keyword" => $keyword,'status'=>1));
        if (empty($func)) {
            $contentUpper = strtoupper($content);
            $func = SmsKeywordModel::model()->findByAttributes(array("sms_keyword" => $contentUpper,'status'=>1));
        }
        if (empty($func) && (SmsHelper::getInstance()->checkValidateSmsDownload($content))) {
            $func = new stdClass();
            $func->exe_func = 'download';
            $func->sms_keyword = 'download';
            $func->status = 1;
        }
        if (empty($func)) {
            $outContent = Yii::app()->params['sms.messageMT']['error_syntax'];
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $outContent, 0, "", $sms_id, $smsc);
            $smsMo->status = 1;
            $smsMo->save();
            //$return->return = "1|fail-saicuphap keyword $keyword";
            //return $return->return;
            return "0|success";
            Yii::app()->end();
        }
        $funcName = $func->exe_func;

        $this->$funcName($service_number, $sender, $content, $keyword, $sms_id, $smsc);
        $smsMo->status = 0;
        $smsMo->save();

        //$return->return = "0|success";
        return "0|success";
        Yii::app()->end();
    } 
        
    private function showprice($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        SmsUser::getInstance()->showprice($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }
    private function subscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        //SmsUser::getInstance()->subscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
        $list_phone_test = Yii::app()->params['list_phone_test'];
        if(isset($list_phone_test) && in_array($sender, $list_phone_test)){
            $this->confirmsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
        }else{
            SmsUser::getInstance()->subscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
        }
    }

    private function unsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->unsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function resetpassword($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->resetpassword($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function registerroffline($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        SmsUser::getInstance()->registerroffline($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function download($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $sender = Formatter::formatPhone($sender);
        $contentCode = trim(SmsHelper::getInstance()->processString($content, $keyword));
        $downloadType = substr($contentCode, 0, 1);
        $contentRealCode = substr($contentCode, 1, strlen($contentCode));
        try {
            switch (strtoupper($downloadType)) {
                case "S":
                    //download Song
                    $ret = SmsSong::getInstance()->download($contentRealCode, $sender, $sender, 'sms', 0, $sms_id);
                    break;
                case "V":
                    //download Video
                    $ret = SmsVideo::getInstance()->download($contentRealCode, $sender, $sender, 'sms', 0, $sms_id);
                    break;
                case "R":
                    //download Ringtone
                    $ret = SmsRingtone::getInstance()->download($contentRealCode, $sender, $sender, 'sms', 0, $sms_id);
                    break;
            }
        } catch (Exception $e) {
            //echo "ERROR: ".$e->getMessage();
        }
    }

    private function customerHelp($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->customerHelp($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function introduction($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->introduction($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }
    
    private function getInfo($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->getInfo($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }


    private function rejectSpam($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsNews::getInstance()->rejectSpam($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function artist_fan($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsNews::getInstance()->artist_fan($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function downTune($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsRbt::getInstance()->download($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    private function searchTune($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsRbt::getInstance()->search($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    // Tìm kiếm bài hát: MA <TenBaiHat> Gui 9234, HOT Gui 9234, QUATANG Gui 9234
    private function searchSong($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsSong::getInstance()->search($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    // Tải bài hát: TAI <MaBaiHat> Gui 9234
    private function downSong($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsSong::getInstance()->down9234($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    // Tin nhắn hướng dẫn: HD Gui 9234
    private function help($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        SmsSong::getInstance()->help($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    /* /*
     *
     * Tặng bài hát: TANG <MaBaiHat> <SoDienThoaiNguoiNhan> Gui 9234,
     * Tặng theo thời gian TANG <MBH> <SDT> <NNTT> <GGPP> Gui 9234
     *
     */

    private function giftSong($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsSong::getInstance()->gift($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    /*
      * Tu choi dich vu
      */
    private function rejectsms($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->rejectsms($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    /*
   * Dang ky lai sms dich vu
   */
    private function acceptsms($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->acceptsms($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    /*
     * dang ky confirm dich vu
     */
    private function confirmsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        SmsUser::getInstance()->confirmsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
    }

    /*
     * dang ky sau khi da confirm
     */
    private function subscribepackage($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $log = new KLogger("test_confirm_sms", KLogger::INFO);
        $log->LogInfo('sender:' . $sender, true);

        $list_phone_test = Yii::app()->params['list_phone_test'];
        if(isset($list_phone_test) && in_array($sender, $list_phone_test)){
            //check xem da gui confirm hay chua
            $params = SmsMoConfirmModel::model()->check_confirm($sender, $content);
            if($params){
                SmsUser::getInstance()->subscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc);
            }else{
                $content = 'Quy khach chua dang ky nen khong the xac thuc duoc!';
                SmsClient::getInstance()->sentSmsText($sender, $content);
                Yii::app()->end();
                return "0|success";
            }
        }
    }

}

/**
 * define type of mo request data
 */
class receiveMoRequestType {

    /**
     * @var string $username
     * @soap
     */
    public $username;

    /**
     * @var string $passwords
     * @soap
     */
    public $password;

    /**
     * @var string $service_number
     * @soap
     */
    public $service_number;

    /**
     * @var string $sender
     * @soap
     */
    public $sender;

    /**
     * @var string $content
     * @soap
     */
    public $content;

    /**
     * @var string $keyword
     * @soap
     */
    public $keyword;

    /**
     * @var string $first_param
     * @soap
     */
    public $first_param;

    /**
     * @var string $last_param
     * @soap
     */
    public $last_param;

    /**
     * @var string $sms_id
     * @soap
     */
    public $sms_id;

    /**
     * @var string $smsc
     * @soap
     */
    public $smsc;

}

/**
 * define type of mo response data
 */
class receiveMoResponseType {

    /**
     * @var string $username
     * @soap
     */
    public $return;

}
