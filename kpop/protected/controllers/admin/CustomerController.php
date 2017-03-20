<?php

@ini_set("max_execution_time", 300);
@ini_set("memory_limit", "1024M");
/*
  @author: GiangNh
 */

class CustomerController extends Controller {

    public $time;

    public function actionIndex() {
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $subscribe = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $subscribe = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone' => $msisdn));
        }
        $this->render('index', compact('subscribe', 'msisdn'));
    }

    public function actionSubscriber() {
        if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
            $createdTime = $_GET['songreport']['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['songreport']['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');

            $model->unsetAttributes();  // clear any default values
            if ($type == '0' || empty($type)) {
                $model->_dkhuy = true;
            } elseif ($type == '1') {
                $model->setAttribute("transaction", "subscribe");
            } elseif ($type == '2') {
                $model->setAttribute("transaction", "unsubscribe");
            }
            $model->setAttribute('user_phone', $msisdn);

            $model->setAttribute('created_time', $this->time);
        }
        $this->render('subcriber', compact('model', 'msisdn', 'type'));
    }

    public function actionLog() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values

            switch ($type) {
                case 0:
                    $model->_content = true;
                    break;
                case 1:
                    $model->setAttribute("transaction", "play_song");
                    break;
                case 2:
                    $model->setAttribute("transaction", "download_song");
                    break;
                case 3:
                    $model->setAttribute("transaction", "play_video");
                    break;
                case 4:
                    $model->setAttribute("transaction", "download_video");
                    break;
            }
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);
        }
        $this->render('log', compact('model', 'msisdn', 'type', 'fromDate', 'toDate', 'time'));
    }

    protected function getGenreName($data, $row) {
        $genreArr = Yii::app()->session['genre'];
        if (isset($genreArr[$data->genre_id]))
            return $genreArr[$data->genre_id];
        else
            return "Nhạc Việt";
    }

    protected function getTransaction($data, $row) {
        switch ($data->transaction) {
            case "download_song":
                return "Tải bài hát";
                break;
            case "play_song":
                return "Nghe bài hát";
                break;
            case "play_video":
                return "Xem video";
                break;
            case "download_video":
                return "Tải video";
                break;
            case "download_ringtone":
                return "Tải nhạc chuông";
                break;
            case "play_album":
                return "Nghe album";
                break;
            case "subscribe":
                return "Đăng ký gói cước";
                break;
            case "unsubscribe":
                return "Hủy gói cước";
                break;
            case "extend_subscribe":
                return "Gia hạn";
                break;
            case "extend_subscribe_level1":
                return "Gia hạn lần 1";
                break;
            case "extend_remain":
                return "Gia hạn lần 2";
                break;
        }
        return "";
    }

    protected function getExtend($data, $row) {
        switch ($data->transaction) {
            case "extend_subscribe":
                return "Gia hạn";
                break;
            case "extend_subscribe_level1":
                return "Gia hạn lần 1";
                break;
            case "extend_remain":
                return "Gia hạn lần 2";
                break;
        }
        return "";
    }

    public function actionSms() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $smsMo = null;
        $smsMt = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $date['toTime'] = $toDate;
            $date['fromTime'] = $fromDate;
            //MO
            $smsMo = new AdminLogSmsMoModel('search');
            $smsMo->setAttribute('sender_phone', "=" . $msisdn);
            $smsMo->setAttribute('receive_time', $date);

            //MT
            $smsMt = new AdminLogSmsMtModel('search');
            $smsMt->setAttribute('receive_phone', "=" . $msisdn);
            $smsMt->setAttribute('send_datetime', $date);
        }
        $this->render('sms', compact('msisdn', 'smsMo', 'smsMt', 'fromDate', 'toDate'));
    }

    public function actionUserAction() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $msisdn = Formatter::formatPhone($msisdn);
        $model = new AdminUserTransactionModel('search');
        $model->unsetAttributes();  // clear any default values
        $model->setAttribute('created_time', $this->time);
        $model->setAttribute('user_phone', $msisdn);
        $this->render('useraction', compact('model', 'fromDate', 'toDate', 'msisdn'));
    }

    public function actionHistory() {

        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);

        }
        $this->render('history', compact('model', 'msisdn', 'fromDate', 'toDate'));
    }

    public function actionExtend() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->_extend = true;
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);
        }
        $this->render('extend', compact('model', 'msisdn', 'type', 'fromDate', 'toDate'));
    }

    public function actionUnRegister()
    {
        $msisdn = Yii::app()->request->getParam('phone', null);
        $pacakage_id = Yii::app()->request->getParam('package_id', null);
        if (Yii::app()->getRequest()->ispostRequest) {
            if (Formatter::isMobiPhoneNumber(Formatter::formatPhone($msisdn)) && !empty($pacakage_id)) {
                $data = Yii::app()->request->getParam('data', '');
                $package = PackageModel::model()->findByPk($pacakage_id);
                $packageCode = $package->code;
                $packageCode = trim($packageCode);
                $params = array(
                    'user_id' => 0,
                    'user_phone' => $msisdn,
                    'package' => $packageCode,
                    'source' => 'cskh',
                    'note_event' => "UNSUB_BY_ADMIN",
                    'options'=>array('send_sms'=>1),
                );
                $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
                $client = new SoapClient($bmUrl, array('trace' => 1));
                $rt = $client->__soapCall('userUnRegister', $params);
                if ($rt->errorCode == 0) {
                    $result['error'] = 0;
                    $result['error_msg'] = 'success';
                    $result['msg'] = "Thành công";
                } else {
                    //display error page
                    if (isset(Yii::app()->params['subscribe_msg'][$rt->message])) {
                        $msg = Yii::t("web", "Error") . ': ' . Yii::app()->params['unsubscribe_msg'][$rt->message];
                        $result['error'] = 1;
                        $result['error_msg'] .= $msg;
                        $result['msg'] = "Có lỗi xảy ra,vui lòng thử lại sau";
                    } else {
                        $msg = Yii::t("web", "Transaction failed, please try again later");//$result->message;
                        $result['error'] = 1;
                        $result['error_msg'] = $msg;
                        $result['msg'] = $msg;
                    }

                    $result['error'] = 1;
                    $result['error_msg'] = "Error: $msg - ({$rt->errorCode})";
                }
                echo CJSON::encode($result);
                exit;
            }
        }
    }
    public function actionRegister() {
        if (Yii::app()->request->isPostRequest) {
            $msisdn = Yii::app()->request->getParam('phone', null);
            $packageCode = Yii::app()->request->getParam('package', null);
            $result = array();
            $result['error'] = 0;
            $result['error_msg'] = '';
            $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
            $client = new SoapClient($bmUrl, array('trace' => 1));
                $packageCode = trim($packageCode);
            $params = array(
                'phone' => Formatter::formatPhone($msisdn),
                'package' => $packageCode,
                'source' => 'cskh',
                'promotion' => 0,
                'bundle' => 0,
                'smsId'=>null,
            );
                $rt = $client->__soapCall('userRegister', $params);
                if(strrpos(strtolower($rt->message), "success") !== false){
                    $result['error'] = 0;
                    $result['msg'] = 'Đăng ký gói cước thành công!';
                }else{
                    $result['error'] = 1;
                    $result['msg'] = Yii::t("web", "Transaction failed, please try again later");
                }
            echo CJSON::encode($result);
            exit;
        }
    }
	
	public function actionLogAction()
	{
		$model = new AdminLogActionModel("search");
        $msisdn = Yii::app()->request->getParam('msisdn', null);
        $model->unsetAttributes();  // clear any default values
		if (isset($_GET['AdminLogActionModel'])){
            $model->setAttribute('msisdn', $msisdn);
			$model->attributes = $_GET['AdminLogActionModel'];
		}
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
		$model->setAttribute('controller', 'customer');
        $model->_cskh = true;

        $action = AdminLogActionModel::model()->getListCSKH();
		$this->render('logAction',compact("model","action",'msisdn'));
	}
	
	public function actionViewLogAction($id)
	{
		$model = AdminLogActionModel::model()->findByAttributes(array("id"=>$id));
		$this->render('viewLogAction',compact("model"));
	}
    public function actionLogRevenue(){
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        if(empty($msisdn)){
            $msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
        }else{
            Yii::app()->session['phone'] = $msisdn;
        }
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->_revenue = true;
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);
        }
        $this->render('revenue', compact('model', 'msisdn', 'type', 'fromDate', 'toDate'));
    }
    
    public function actionFreeData()
    {
    	$file = Yii::getPathOfAlias("application.components.bm")."/SubSyncData.php";
    	include_once $file;
    	
    	$msisdn = Yii::app()->request->getParam('phone', null);
    	if(empty($msisdn)){
    		$msisdn = isset(Yii::app()->session['phone'])? Yii::app()->session['phone'] : '84';
    	}else{
    		Yii::app()->session['phone'] = $msisdn;
    	}
    	$msisdn = Formatter::formatPhone($msisdn);
    	$subscribe = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone' => $msisdn));
    	
    	$freeDataStatus = SubSyncData::getInstance()->getStatus($msisdn);

    	$this->render("freeData",compact("freeDataStatus","subscribe","msisdn"));
    	
    	
    }

    public function actionUse(){
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $type = Yii::app()->request->getParam('type', '');
        $model = null;
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->_use = true;
            if($type != '' && $type != 'all'){
                $model->setAttribute('transaction', $type);
            }
            $model->setAttribute('created_time', $this->time);
        $array = array(
            'all'=>"Tất cả",
            'play_song'=>'Nghe bài hát',
            'download_song'=>'Tải bài hát',
            'play_video'=>'Xem video',
            'download_video'=>'Tải video',
        );
        $this->render('use', compact('model', 'type', 'array', 'fromDate', 'toDate'));
    }
}
