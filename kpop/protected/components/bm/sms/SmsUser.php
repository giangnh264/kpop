<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsUser
 *
 * @author longnt2
 * Function
 *      + subscribe: Dang ky dich vụ
 *      + unsubscribe: Huy dich vu
 *      + resetpassword: Lay lai mat khau
 *      + customerHelp: Tro giup
 *      + exhibition: Trien lam VN Mobile: su dung dich vu cua Vclip và Chacha mien phi toi 24h cung ngay
 *      + introduction: Gioi thieu
 *      + trialsubs: Dang ky dung thu
 *      + debitSubs: Dang ky no cuoc.
 */
class SmsUser {

    protected static $_instance = null;

    private function __clone() {

    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function subscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $content = trim($content);
        $content = str_replace(" ", "", $content);
        $content = strtoupper($content);
        $package = PackageModel::model()->findByAttributes(array("sms_command_code" => $content));
        if (empty($package)) {
            switch($content) {
                case "DKA1":
                case "YA1":
                    $commandCode = "DKA1";
                    break;
                case "DKA7":
                case "YA7":
                    $commandCode = "DKA7";
                    break;
                case "DKA30":
                case "YA30":
                    $commandCode = "DKA30";
                    break;
                case "KM":
                    $commandCode = "DKA1";
                    break;
                case "KM1":
                    $commandCode = "DKA1";
                    break;
                case "KM2":
                    $commandCode = "DKA7";
                    break;
                default:
                    $commandCode = $keyword;
                    break;
            }
            $package = PackageModel::model()->findByAttributes(array("sms_command_code" => $commandCode));
        }
        if (empty($package)) {
            // default package is the first active package
            $package = PackageModel::model()->findByAttributes(array("status" => PackageModel::ACTIVE));
            $package_code = $package->code;
        } else {
            $package_code = $package->code;
        }
        $sender = Formatter::formatPhone($sender);
        try {
            $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
            $client = new SoapClient($bmUrl, array('trace' => 1));
            $params = array(
                'user_phone' => $sender,
                'package' => $package_code,
                'source' => 'sms',
                'promotion' => '0',
                'bundle' => 0,
                'smsId' => $sms_id,
                'note_event' => ""
            );
            // update note
            $params['note_event'] = $keyword;
            $ret = $client->__soapCall('userRegister', $params);
        } catch (Exception $e) {
			Yii::log($e->getMessage(), "error", "exeption.BMException");
        }
    }

    public function registerroffline($service_number, $sender, $content, $keyword, $sms_id, $smsc){
       //check in package_offline
        $package_offline = PackageOfflineModel::model()->findbyAttributes(array('code'=>$content));
        $package_code = $package_offline->package_code;
        $package = PackageModel::model()->findByAttributes(array("code" => $package_code));
        if($package){
            try {
//                if(trim($content) == 'Y' || trim($content) == 'M'){
                if(strtoupper(trim($content)) == 'Y'){
                    $par = array(
                        'phone' => Formatter::formatPhone($sender),
                        'package' => $package_code,
                        'source' => 'sms',
                        'promotion' => 0,
                        'bundle' => 0,
                        'smsId' => $sms_id,
                        'note_event' => $content,
                    );
                }elseif (strtoupper(trim($content)) == 'T' || strtoupper(trim($content)) == 'M'){
                    $par = array(
                        'phone' => Formatter::formatPhone($sender),
                        'package' => $package_code,
                        'source' => 'sms',
                        'promotion' => 0,
                        'bundle' => 0,
                        'smsId' => $sms_id,
                        'note_event' => 'VOICE_BROADCAST',
                    );
                }else{
                    $options = array();
                    $options['price'] = (int) $package['fee'];
                    $options['charge'] = (int) 1;
                    $options['free_day'] =  0;
                    $par = array(
                        'phone' => Formatter::formatPhone($sender),
                        'package' => $package_code,
                        'source' => 'sms',
                        'bundle' => 0,
                        'smsId' => $sms_id,
                        'promotion' => 0,
                        'note_event' => $content,
                        'options'=>$options,
                    );
                }

                $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
                $client = new SoapClient($bmUrl, array('trace' => 1));
                $result = $client->__soapCall('userRegister', $par);
            }catch (Exception $e) {
                Yii::log($e->getMessage(), "error", "exeption.BMException");
            }
        }
    }

    public function unsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        try {
            $content = trim($content);
            $content = str_replace(" ", "", $content);
        	$content = strtoupper($content);
            switch($content) {
                case "HUYA1":
                    $commandCode = "A1";
                    break;
                case "HUYA7":
                    $commandCode = "A7";
                    break;
                case "HUYA30":
                    $commandCode = "A30";
                    break;
                default:
                    $commandCode = $content;
                    break;
            }
            $phone = Formatter::formatPhone($sender);
            $user_package = BmUserSubscribeModel::model()->findByAttributes(array("user_phone" => $phone, 'status'=>1));
            $package = PackageModel::model()->findbyPk($user_package->package_id);
            if(!empty($user_package) && $package->code != $commandCode){
                //sai cu phap
                $sms_content = Yii::app()->params['sms.messageMT']['error_syntax'];
                $smsClient = new SmsClient();
                $smsClient->sentMT($service_number, $sender, "0", $sms_content, 0, "", $sms_id, $smsc);
            }else{
                $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
                $client = new SoapClient($bmUrl, array('trace' => 1));
                $params = array(
                    'user_id' => 0,
                    'user_phone' => $phone,
                    'package' => $package->code,
                    'source' => 'sms',
                );
                $ret = $client->__soapCall('userUnRegister', $params);
            }

        } catch (Exception $e) {
            Yii::log($e->getMessage(), "error", "exeption.BMException");
        }
    }

    public function resetpassword($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $sender = Formatter::formatPhone($sender);
        //checkuser
        $check_user = UserModel::model()->findByAttributes(array('phone'=>$sender));
        if(empty($check_user) || !isset($check_user)){
            //neu khong ton tai nguoi dung thi tao 1 tk moi va gui sms tin nhan mat khau
            $password = Common::randomPassword();
            $params = array();
            $params['username'] = $sender;
            $params['fullname'] = $sender;
            $params['msisdn'] = $sender;
            $params['status'] = UserModel::ACTIVE;
            $params['password'] = $password ['encoderPass'];
            $create_user = UserModel::model()->add($params);
            $user = array();
            if ($create_user) {
                $msg = Yii::t('web', Yii::app()->params['subscribe']['reset_password'], array('{:PHONE}'=>$sender,'{:PASSWORD}' => $password ['realPass']));
                $user["msg"] = $msg;
            } else {
                $user["msg"] = "An error occurred. Please try again later.";
            }
        }else{
            $user = UserModel::model()->resetpassword($sender);
        }
        $smsClient = new SmsClient();
        $smsClient->sentMT($service_number, $sender, "0", $user["msg"], 0, "", $sms_id, $smsc);
    }

    // Tro giup thong tin tu dich vu
    public function customerHelp($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $smsClient = new SmsClient();
        $content = Yii::app()->params['sms_help'];
        $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

    // Trien lam VN Mobile: su dung dich vu cua Vclip và Chacha mien phi toi 24h cung ngay
    public function exhibition($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        /**
         * CLOSE KICH BAN DUNG THU DO UPDATE CHARGING
         * By: tungnv
         */
        $content = "Xin thong bao, kich ban dung thu cua dich vu da bi dong. De dang ky dich vu, QK hay soan tin DK CHACHA gui 9234.";
        $smsClient = new SmsClient();
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
        return;
        Yii::app()->end();
        // CLOSE END HERE

        Yii::import("application.components.bm.*");
        $phone = $sender;
        $smsClient = new SmsClient();
        if (!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))) {
            $content_ = "Chi nhung thue bao cua VinaPhone moi duoc huong khuyen mai. Xim cam on.";
            $smsClient->sentMT($service_number, $sender, "0", $content_, 0, "", $sms_id, $smsc);
        } else {
            try {
                // send message truoc khi xu li
                $content_ = Yii::app()->params['sms.messageMT']['exhibition'];
                $smsClient->sentMT($service_number, $sender, "0", $content_, 0, "", $sms_id, $smsc);
                // Dang ki dich vu Chacha
                $phone = Formatter::formatPhone($phone);
                $checkUser = UserModel::model()->checkUserPhone($phone);
                $userSub = UserSubscribeModel::model()->getByPhone($phone);
                $pass = bmCommon::randomPassword();
                $params['username'] = Formatter::formatPhone($phone);
                $params['password'] = $pass['encoderPass'];
                $params['realPass'] = $pass['realPass'];
                $params['msisdn'] = $phone;
                $params['packageId'] = 3;
                $params['createdDatetime'] = date("Y-m-d H:i:s");
                $params['expired_time'] = date("Y-m-d H:i:s");
                $params['event'] = 'TLVT-10-2012';

                if (!$checkUser) {
                    $user = UserModel::model()->add($params);
                    $params['user_id'] = $user->id;
                } else {
                    $params['user_id'] = $checkUser->id;
                }
                if (empty($userSub) || $userSub->status <> 1) {
                    UserSubscribeModel::model()->register($params, $userSub);
                    //$content_ = Yii::app()->params['sms.messageMT']['exhibition'];
                }
                bmCommon::logFile("TL: - Service:Chacha - Phone:$phone - CreatedTime:" . date("Y-m-d H:i:s") . " - UserId:{$params['user_id']} ", 'exhibition', 'chacha_exhibition');
                /// Dang ki dich vu Vclip
                $params = array(
                    'username' => 'vclip',
                    'password' => 'vclip123312##',
                    'msisdn' => $phone,
                );
                $client = new SoapClient('http://test.vclip.vn/webservice/subscribefree.php?wsdl',
                                array('connection_timeout' => 5));
                $results = $client->__soapCall('subscribefree', array('parameters' => $params));
                $result = $results->return;
                bmCommon::logFile("TL: - Service:Vclip - Phone:$phone - CreatedTime:" . date("Y-m-d H:i:s") . " - UserId:{$params['user_id']} ", 'exhibition', 'vclip_exhibition');
            } catch (Exception $e) {
                $content_ = "Da co loi xay ra, vui long thu lai sau. Xin cam on qui khach.";
            }
        }
//        $smsClient->sentMT($service_number, $sender, "0", $content_, 0, "", $sms_id, $smsc);
    }

    public function introduction($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $smsClient = new SmsClient();
        $content = "";
        $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

    public function trialsubs($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        /**
         * CLOSE KICH BAN DUNG THU DO UPDATE CHARGING
         * By: tungnv
         */
        $content = "Xin thong bao, kich ban dung thu cua dich vu da bi dong. De dang ky dich vu, QK hay soan tin DK CHACHA gui 9234.";
        $smsClient = new SmsClient();
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
        return;
        Yii::app()->end();
        // CLOSE END HERE

        $sender = Formatter::formatPhone($sender);
        $userSubs = UserSubscribeModel::model()->findByAttributes(array('user_phone' => $sender, 'status' => UserSubscribeModel::ACTIVE));
        $trialMode = UserModel::model()->isTrial($sender);
        if (!empty($trialMode) || !empty($userSubs)) {
            if (!empty($trialMode))
                $msg = "Bạn đã đăng ký dùng thử Chacha. Đăng nhập bằng số điện thoại của bạn và mật khẩu đã cấp. Quên mật khẩu, soạn MK gửi 9234 (miễn phí)";
            else
                $msg = "Bạn đã đăng ký sử dụng dịch vụ Chacha. Đăng nhập bằng số điện thoại của bạn và mật khẩu đã cấp. Quên mật khẩu, soạn MK gửi 9234 (miễn phí)";
            $smsClient = new SmsClient();
            $ret = $smsClient->sentMT($service_number, $sender, "0", $msg, 0, "", $sms_id, $smsc);
        }else {
            if (Formatter::isPhoneNumber($sender)) {
                $res = UserSubscribeTrialModel::model()->createTrial($sender);
                if ($res['error_code'] == 0) {
                    $time = $res['expired_time'];
                    $str = "";
                    if ($res['password'])
                        $str = ". Đăng nhập Chacha bằng số điện thoại của bạn và password: " . $res['password'];
                    $msg = "Bạn đã đăng ký dùng thử thành công. Bạn được dùng hoàn toàn MIỄN PHÍ dịch vụ ChaCha đến ngày {$time} " . $str;
                }else {
                    $msg = "Xảy ra lỗi khi lưu thông tin người dùng";
                }
                try {
                    $smsClient = new SmsClient();
                    $ret = $smsClient->sentMT($service_number, $sender, "0", $msg, 0, "", $sms_id, $smsc);
                } catch (Exception $e) {
                    $ret = 'SENT fail';
                }
                $logmsg = $ret;
            } else {
                $logmsg = "not is vinaphone";
            }
        }
    }

    public function debitSubs($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        /**
         * CLOSE KICH BAN DUNG THU DO UPDATE CHARGING
         * By: tungnv
         */
        $content = "Xin thong bao, kich ban dung thu cua dich vu da bi dong. De dang ky dich vu, QK hay soan tin DK CHACHA gui 9234.";
        $smsClient = new SmsClient();
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
        return;
        Yii::app()->end();
        // CLOSE END HERE

        $sender = Formatter::formatPhone($sender);
        //CHECK IS ACTIVE
        $userSubscribe = UserSubscribeModel::model()->get($sender);
        if (!empty($userSubscribe)) {
            $content = Yii::app()->params['subscribe']['duplicate_package_chachafun'];
            $smsClient = new SmsClient();
            $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
            return;
            Yii::app()->end();
        }
        $newUser = false;
        $subsDebitMonth = UserSubscribeDebitModel::model()->subs_exists($sender, true); // CHECK TRONG 30 NGAY

        if (!empty($subsDebitMonth)) {
            // Đã đăng ký nợ cước trước đó 30 ngay
            $content = Yii::app()->params['subscribe']['chachafun_duplicate_debit'];
            try {
                $smsClient = new SmsClient();
                $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
            } catch (Exception $e) {
                $ret = 'SENT fail';
            }
        } else {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // Tao user
                $checkUser = UserModel::model()->checkUserPhone($sender);
                if (!$checkUser) {
                    $password = rand(1000, 9999);
                    $params['username'] = 'chacha' . md5('chacha' . rand() . time());
                    $params['password'] = Common::endcoderPassword($password);
                    $params['msisdn'] = $sender;
                    $user = UserModel::model()->add($params);
                    $userId = $user->id;
                    $newUser = true;
                } else {
                    $userId = $checkUser->id;
                }
                // Tao usersubscribe debit
                $checkUserDebit = userSubscribeDebitModel::model()->subs_exists($sender);
                if (!empty($subsDebitMonth)) {
                    $subsDebitMonth->updated_time = new CDbExpression("NOW()");
                    $subsDebitMonth->save();
                } else {
                    $subsDebitModel = UserSubscribeDebitModel::model()->addNew($sender, 3);
                }

                //Tao user subscribe
                $userSub = UserSubscribeModel::model()->getByPhone($sender);
                $timestam = time() + 7 * 24 * 60 * 60;
                $params = array(
                    'user_id' => $userId,
                    'packageId' => 3,
                    'createdDatetime' => new CDbExpression("NOW()"),
                    'expired_time' => new CDbExpression("NOW()"),
                    'event' => "DK_NOCUOC",
                    'msisdn' => $sender,
                );
                UserSubscribeModel::model()->register($params, $userSub);

                //LOG TRANSACTION
                $params = array(
                    'user_id' => $userId,
                    'msisdn' => $sender,
                    'price' => 0,
                    'packageId' => 3,
                    'cmd' => 'subscribe_debit',
                    'source' => 'sms',
                    'obj1_id' => 3,
                    'obj1_name' => 'CHACHAFUN',
                    'obj2_name' => $sender,
                    'createdDatetime' => new CDbExpression("NOW()"),
                    'return_code' => 0,
                    'note' => 'DK_NOCUOC',
                );
                BmUserTransactionModel::model()->add($params);

                $transaction->commit();
            } catch (Exception $e) {
                $contentLog = "ERROR: " . $e->getMessage(); //must log file
                $transaction->rollback();
            }
            //SENT MSG
            $content = Yii::app()->params['subscribe']['success'];
            $smsClient = new SmsClient();
            $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
            if ($newUser) {
                $content2 = Yii::t('bm', Yii::app()->params['subscribe']['success_send_password'], array('{PACKAGE}' => 'CHACHAFUN', '{PASSWORD}' => $password));
                $ret = $smsClient->sentMT($service_number, $sender, "0", $content2, 0, "", $sms_id, $smsc);
            }
        }
    }
    
    public function getInfo($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
    	$sender = Formatter::formatPhone($sender);
    	$userSubscribe = UserSubscribeModel::model()->get($sender);
    	
    	if(!empty($userSubscribe)){
    		//Dang active
    		$packageId = $userSubscribe->package_id;
    		if($packageId == 1){
    			$packageInfo = "A1";
                $price = '2.000d/ngay';
    		}elseif ($packageId == 3){
                $packageInfo = "A30";
                $price = '30.000d/thang';
            } else{
    			$packageInfo = "A7";
                $price = '7.000d/tuan';
    		}
    		$expired = date("d/m/Y",strtotime($userSubscribe->expired_time));
            $content = "Quy khach hien dang su dung goi cuoc $packageInfo cua dich vu Amusic $price, han su dung den $expired. Truy cap http://amusic.vn de thuong thuc cac bai hat, MV HOT nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!";
    	}else{
    		// Ko active
    		$content  = "Xin loi, Quy khach chua dang ky goi cuoc dich vu Amusic cua MobiFone. De dang ky nghe nhac chat luong cao va mien cuoc 3G khi su dung, soan DK Tengoi gui 9166 (Tengoi: A1 - 2000d/ngay; A7 - 7000d/tuan). Chi tiet truy cap http://amusic.vn  hoac goi 9090 (200d/phut). Tran trong cam on!";
    	}
		SmsClient::getInstance()->sentSmsText($sender, $content);	
    }
    
    
	public function add($params) {
		$userModel = new UserModel();
		$userModel->username 	= isset($params['username'])?$params['username']:'';
		$userModel->password 	= isset($params['password'])?$params['password']:'';
		$userModel->fullname 	= isset($params['fullname'])?$params['fullname']:'';
		$userModel->phone		= isset($params['msisdn'])?$params['msisdn']:'';
		$userModel->email		= isset($params['email'])?$params['email']:'';
		$userModel->gender 		= isset($params['gender'])?$params['gender']:'1';
		$userModel->address 		= isset($params['address'])?$params['address']:'';
		$userModel->suggested_list 		= isset($params['suggested_list'])?$params['suggested_list']:'';
		$userModel->created_time = date("Y-m-d H:i:s");
		$userModel->updated_time = date("Y-m-d H:i:s");
		$userModel->status 		= isset($params['status'])?$params['status']:UserModel::ACTIVE;
		$userModel->client_id = isset($params['client_id'])?$params['client_id']:'';
		$userModel->save();
		return $userModel;
	}

    public function showprice($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        $content = Yii::app()->params['price']['show_price'];
        $smsClient = new SmsClient();
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

    public function rejectsms($service_number, $sender, $content, $keyword, $sms_id, $smsc){

        $keyword = trim($content);
        $keyword = strtoupper($keyword);
        $keyword = str_replace(" ","",$keyword);
        if($keyword == 'TCSMSA1' ){
            $sms_content = Yii::app()->params['sms_tc']['sms_tc_am1'];
        }elseif($keyword == 'TCSMSA7'){
            $sms_content = Yii::app()->params['sms_tc']['sms_tc_am7'];
        }else{
            $sms_content = Yii::app()->params['sms.messageMT']['error_syntax'];
            SmsClient::getInstance()->sentSmsText($sender, $sms_content);
            Yii::app()->end();
            return "0|success";
        }
        $checkuser = DeletedPhoneModel::model()->findbyPk(Formatter::formatPhone($sender));
        if(empty($checkuser)){
            $deleted_phone = new DeletedPhoneModel();
            $deleted_phone->phone = Formatter::formatPhone($sender);
            $deleted_phone->save();
        }
        SmsClient::getInstance()->sentSmsText($sender, $sms_content);
        return "0|success";
    }

    public function acceptsms($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        $content = trim($content);
        $content = strtoupper($content);
        $content = str_replace(" ","",$content);
        if($content == 'DKSMSA1'){
            $sms_content = Yii::app()->params['sms_dk']['sms_dk_a1'];
        }elseif($content == 'DKSMSA7'){
            $sms_content = Yii::app()->params['sms_dk']['sms_dk_a7'];
        }else{
            $sms_content = Yii::app()->params['sms.messageMT']['error_syntax'];
            SmsClient::getInstance()->sentSmsText($sender, $sms_content);
            Yii::app()->end();
            return "0|success";
        }
        $checkuser = DeletedPhoneModel::model()->findbyPk(Formatter::formatPhone($sender));
        if(!empty($checkuser)){
            $query = "DELETE FROM `deleted_phone` WHERE phone = :PHONE";
            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":PHONE", Formatter::formatPhone($sender), PDO::PARAM_STR);
            $command->execute();
        }
        SmsClient::getInstance()->sentSmsText($sender, $sms_content);
        return "0|success";
    }

    public function confirmsubscribe($service_number, $sender, $content, $keyword, $sms_id, $smsc){
        //check xem da dang ky goi cuoc khac chua
        $user_sub = UserSubscribeModel::model()->get($sender);
        if($user_sub ){
            //tra tin nhan dang su dung
            $package = PackageModel::model()->findByPk($user_sub->package_id);
            $message = 'duplicate_package_'.strtolower($package->code);
            $content = Yii::app()->params['subscribe'][$message];
            $content = str_replace(":EXPIRED", date("d/m/Y",strtotime($user_sub->expired_time)), $content);
        }else{
            //insert into sms_mo_confirm
            $begin_time= date('Y-m-d H:i:s', time() - (60 * 30));
            $sql = "UPDATE sms_mo_confirm SET confirm_status = 2 WHERE msisdn = '{$sender}' AND created_time >= '{$begin_time}'";
            Yii::app()->db->createCommand($sql)->execute();

            //insert into sms_mo_confirm
            $content = trim($content);
            $content = str_replace(" ", "", $content);
            $content = strtoupper($content);
            $package = PackageModel::model()->findByAttributes(array("sms_command_code" => $content));
            $package_code = $package->code;
            $model = new SmsMoConfirmModel();
            $model->msisdn = $sender;
            $model->content = $package_code;
            $model->package_id = $package->id;
            $model->confirm_status = 0;
            $model->created_time = date('Y-m-d H:i:s');
            $model->save();
            //send sms
            //check promotion
            if($this->check_promotion($sender)){
                $message = 'success_msg_confirm_km_'.strtolower($package->code);
            }else{
                $message = 'success_msg_confirm_'.strtolower($package->code);
            }
            $content = Yii::app()->params['subscribe'][$message];
        }

        SmsClient::getInstance()->sentSmsText($sender, $content);
        Yii::app()->end();
        return "0|success";
    }


    private function check_promotion($phone)
    {
        $sql = "SELECT *
	        	FROM user_subscribe_km
	        	WHERE phone = '{$phone}'
        		AND (type = 0 OR (type = 1 AND created_time >= date_sub(NOW(), interval 2160 hour)))
        		";

        $subscribe = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($subscribe)){
            return false;
        }
        return true;
    }

}

?>