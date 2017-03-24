<?php
class TransLogController extends Controller
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
							'web'=>'Web',
							'wap'=>'Wap',
							'api-ios'=>'IOS Apps',
							'api-android'=>'ANDROID Apps',
							'sms'=>'SMS',
							'auto'=>'System',
							'vinaphone'=>'VinaPhone Call',
							'admin'=>'Backend'
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
		if(isset($_GET['filter'])){
			$this->state = true;
			$this->phone =  $_GET['filter']['phone'];
			$this->channel =  $_GET['filter']['channel'];
			$this->transType =  $_GET['filter']['transType'];
			$this->objId1 =  $_GET['filter']['obj1_id'];
			$this->objId2 =  $_GET['filter']['obj2_id'];
			if($_GET['filter']['time'] !=""){
				$createdTime = $_GET['filter']['time'];
				if(strrpos($createdTime, "-")){
					$createdTime = explode("-", $createdTime);
					$fromDate = explode("/", trim($createdTime[0]));
					$fromDate = $fromDate[2]."-".str_pad($fromDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
					$toDate = explode("/", trim($createdTime[1]));
					$toDate = $toDate[2]."-".str_pad($toDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
					$this->time = array('from'=>$fromDate." 00:00:00",'to'=>$toDate." 23:59:59");
				}else{
					$time = explode("/", trim($_GET['filter']['time']));
					$time = $time[2]."-".str_pad($time[0], 2, '0', STR_PAD_LEFT)."-".str_pad($time[1], 2, '0', STR_PAD_LEFT);
					$this->time = array('from'=>$time." 00:00:00",'to'=>$time." 23:59:59");
				}
			}else{
					$startDay = date("Y")."-".date("m")."-01";
					$fromDate = date("Y-m-d 00:00:00",strtotime($startDay));
					$toDate = date("Y-m-d 23:59:59");
					$this->time = array('from'=>$fromDate,'to'=>$toDate);
			}
		}
	}

	public function actionIndex()
	{
		$model=new AdminUserTransactionModel('search');
		
		if($this->state && $this->phone){
			$this->phone = Formatter::formatPhone(Formatter::removePrefixPhone($this->phone));
			$model->unsetAttributes();  // clear any default values
			$model->setAttribute('user_phone', $this->phone);
			$model->setAttribute('created_time', $this->time);
			if(isset($this->channel) && $this->channel != ""){
				$model->setAttribute('channel', $this->channel);	
			}
			if(isset($this->transType) && $this->transType != ""){
				$model->setAttribute('transaction', $this->transType);	
			}
			if(isset($this->objId1) && $this->objId1 != ""){
				$model->setAttribute('obj1_id', $this->objId1);	
			}
			if(isset($this->objId2) && $this->objId2 != ""){
				$model->setAttribute('obj2_id', $this->objId2);	
			}
		}
				
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionSendsms()
	{
		
		if(Yii::app()->request->isajaxrequest){
			$userPhone = Yii::app()->request->getParam('user_phone');
			$idContent = Yii::app()->request->getParam('content_id',0);
			$trans = Yii::app()->request->getParam('trans_type');
		
			if($userPhone && Formatter::isPhoneNumber(Formatter::removePrefixPhone($userPhone))){
				$userPhone = Formatter::formatPhone(Formatter::removePrefixPhone($userPhone));
				$sms= new SmsClient();
				
				switch ($trans){
					case "download_song":
						$content = "Chacha gui ban link tai bai hat: http://m.chacha.vn/refun?type=dlsong&id=$idContent";
						$contentObj = AdminSongModel::model()->findByPk($idContent);
						break;
					case "download_video":
						$content = "Chacha gui ban link tai video: http://m.chacha.vn/refun?type=dlvideo&id=$idContent";
						$contentObj = AdminVideoModel::model()->findByPk($idContent);
						break;
					case "download_ringtone":
						$content = "Chacha gui ban link nhac chuong: http://m.chacha.vn/refun?type=dlringtone&id=$idContent";
						$contentObj = AdminRingtoneModel::model()->findByPk($idContent);
						break;
				}
				if(empty($contentObj)){
					echo "<div class='err'>Lỗi: Không tồn tại nội dung tương ứng với ID {$idContent} </div>";
					Yii::app()->end();
				}
                                
				$res = $sms->sentMT("9234", $userPhone, 0, $content, 0, "", time(), 9234);
				
				if($res == '0|Success'){
					$refunModel = new AdminRefunContentModel();
					$refunModel->phone = $userPhone;
					$refunModel->action = $trans;
					$refunModel->action = $trans;
					$refunModel->content_id = $idContent;
					$refunModel->created_time = date("Y-m-d H:i:s");
					$refunModel->save();					
					
					echo "<div class='success'>Gửi tin nhắn thành công đến số $userPhone </div>";	
				}else{
					echo "<div class='err'>Lỗi: Không gửi được tin nhắn đến số $userPhone Lỗi:  $res->return</div>";
				}
			}else{
				echo "<div class='err'>Lỗi: Số điện thoại $userPhone không phải của Vinaphone</div>";
			}
			Yii::app()->end();
		}
		$_GET['msg'] = "Truy cập bị từ trối";
		$this->forward('admin/error', true);		
	}
}