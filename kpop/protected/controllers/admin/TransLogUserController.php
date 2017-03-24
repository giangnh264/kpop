<?php
class TransLogUserController extends Controller
{
	public $phone;
	public $time;
	public $channel;
	public $transType;
	public $objId1;
	public $objId2;
	public $state = false;
	public $channelList = array(
							''=>'Tất cả',
							'vinaphone'=>'VinaPhone Call',
						);
	public $transList = array(
								''=>'Tất cả',
								'subscribe'=>'subscribe',
								'subscribe_ext'=>'subscribe_ext',
								'unsubscribe'=>'unsubscribe',
								'play_song'=>'play_song',
								'download_song'=>'download_song',
								'play_album'=>'play_album',
								'play_video'=>'play_video',
								'download_video'=>'download_video',
								'download_ringtone'=>'download_ringtone',
						);

	public function init()
	{
		parent::init();
	}

	public function actionViewlog()
	{
		/* $ip = $_SERVER['REMOTE_ADDR'];
		$blackList = $this->_whilelistIP();
		if(!in_array($ip, $blackList)){
			echo '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
			echo "IP của bạn <b>{$ip}</b> không được cấp quyền truy cập nội dung này!";
			Yii::app()->end();
		} */
		Yii::app()->user->setState('pageSize',5);
	
		$phone = Yii::app()->request->getParam('phone',null);
		$isAll = Yii::app()->request->getParam('all',0);
		$isFull = Yii::app()->request->getParam('full',0);
		$channel = Yii::app()->request->getParam('channel',0);
		$subscribe = null;
		$smsMo = $smsMt = $model = $modelDK = null;
		$params = array();
		if($phone && Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
			//log đăng ký và hủy
			if(empty($channel)){
				$modelDK = new AdminUserTransactionModel('search');
				$modelDK->unsetAttributes();  // clear any default values
				$phone = Formatter::formatPhone($phone);
				$modelDK->setAttribute('user_phone', $phone);
				$modelDK->_dkhuy=true;
			}else{
				//vinaphone
				$modelDKViNA = new LogApiVinaphoneModel('search');
				$modelDKViNA->unsetAttributes();  // clear any default values
				$phone = Formatter::formatPhone($phone);
				$modelDKViNA->setAttribute('msisdn_a', $phone);
				//$modelDKViNA->setAttribute('error_id', 0);
				$modelDKViNA->_dkhuy=true;
				$params['modelDKViNA']=$modelDKViNA;
			}
			//gia hạn
			$modelRenew = new AdminUserTransactionModel('search');
			$modelRenew->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelRenew->setAttribute('user_phone', $phone);
			$modelRenew->setAttribute('transaction', 'subscribe_ext');
			$params['modelRenew']=$modelRenew;
			//log content
			$modelContent = new AdminUserTransactionModel('search');
			$modelContent->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelContent->setAttribute('user_phone', $phone);
			$modelContent->_content=true;
			$params['modelContent']=$modelContent;
			$subscribe = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone));
	
		}
		$this->render('viewlog',
				CMap::mergeArray(array(
				'channel'=>$channel,
				'phone'=>$phone,
				'subscribe'=>$subscribe,
				'modelDK'=>$modelDK,
				),$params)
		);
	}
}