<?php
abstract class BaseGiftSong extends BaseBusiness{

	protected $songObj;
    protected $giftId;
	public function doGiftSong() {
		if ($this->_prepare() == 'success'){  // errorCode = 0
			if ($this->_doBiz() == 'success'){  //errorCode = 0
				$this->_success();
				return $this->result;
			}
		}
		$this->_error();
		return $this->result;
	}
	/**
	 * Check param then
	 * Get song, price, quota
	 * Define Business
	 * @return 0 if success, others if not
	 */
	private function  _prepare() {

		//prepare params for execute
		$this->params['cmd'] = Yii::app()->params['cmd.song.gift'];
		$this->params['obj2_name'] = $this->params['to_phone'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction

		//check valid params
		if (!(($this->params['msisdn']) &&
		($this->params['itemCode']) &&     //Code
		(isset($this->params['source'])))
		){
			$this->result['error'] = 'invalid_params';
			return $this->result['error'];
		}

		//get Song Object by Code
		$this->songObj = BmSongModel::model()->getSongByCode($this->params['itemCode']);
		if ($this->songObj) {
			$this->result['error'] =  $this->defineBiz();
		}else {
			//prepare params to log
			$this->result['error'] = 'song_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error'];
		}
		//bmCommon::logFile('['.$this->params['msisdn'].'][download song]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']'.$this->params['source'],'userActivity','download');
		//save activity
		try {
			//log Db
			BmUserActivityModel::model()->add($this->params);
		}
		catch (Exception $e)
		{
			//add log file
			bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'gift_song');
		}
		return $this->result['error'];

	}

	/**
	 * Charging and Update User_subscribe
	 * @return type
	 */
	private function _doBiz() {

		//start transaction (update memcached)
		if ($this->_startTransaction()) {
			if($this->params['reason'] == 'CONTENT' || $this->params['price'] > 0){
				$this->params['reason'] = 'CONTENT';
				$this->params['charge_note'] = '';
				$this->params['promotion'] = 0;
				$this->result['error'] = Transaction::doChargeMSgift($this->params);
			}else{
				$this->result['error'] = Transaction::doChargeContent($this->params);
			}

			if($this->result['error']=='success'){
				try {
					/*$arDateTime = explode(":", $this->params['delivery_time']);
					$day = substr($arDateTime[0], 0, 2);
					$month = substr($arDateTime[0], 2);
					$minute = substr($arDateTime[1], 2);
					$hour = substr($arDateTime[1], 0, 2);
					$year = date('Y', time());
					$DateTime = "$year-$month-$day $hour:$minute:00";
					*/

					$mg_gift = new MgGiftModel();

					$mg_gift->from_phone = $this->params['msisdn'];
					$mg_gift->to_phone = $this->params['to_phone'];
					$mg_gift->song_code = $this->params['itemCode'];
					$mg_gift->song_id = $this->songObj->id;
					$mg_gift->song_nicename = Common::strNormal($this->songObj->name);
					$mg_gift->song_path = SongModel::model()->getIvrSongPath($this->songObj->id);
					$mg_gift->created_time = new CDbExpression("NOW()");
					$mg_gift->updated_time = new CDbExpression("NOW()");
					$mg_gift->type_send = 1;
					$mg_gift->status = 0;
					$mg_gift->type = 1;

					if ($this->params['send_now'] == 1) {
						$mg_gift->delivery_time = new CDbExpression("NOW()");
					} else {
						$mg_gift->delivery_time = $this->params['delivery_time'];
					}
					$ret = $mg_gift->save();
					$this->giftId = $mg_gift->id;

					if($ret && (
						(isset($this->params['record_filePath']) && $this->params['record_filePath'] != '')
						|| (isset($this->params['message']) && $this->params['message']!= "")
						))
					{
						$message = new MgMessageModel();
						$message->gift_id = $mg_gift->id;
	                    $message->msisdn = $this->params['msisdn'];
	                    if(isset($this->params['record_filePath']) && $this->params['record_filePath'] != ''){
	                    	$message->path = $this->params['record_filePath'];
	                    }
	                    if(isset($this->params['message']) && $this->params['message']!= ""){
//	                    	$message->type = 2;
	                    	$message->message = $this->params['message'];
	                    }
	                    $message->save();
					}

					if(!$ret){
						$this->result['error'] = CVarDumper::dumpAsString($mg_gift->getErrors());
						bmCommon::logFile($this->params['msisdn'].'-'.$this->result['error'],'userActivity', 'gift_song');
					}
				}catch (Exception $e){
					$this->result['error'] = 'error:'.$e->getMessage();
					bmCommon::logFile($this->params['msisdn'].'-'.$this->result['error'],'userActivity', 'gift_song');
				}
			}
			//finish transaction
			$this->_finishTransaction();
		}else {
			$this->result['error'] = 'transaction_forbidden'; // TRANSACTION_FORBIDDEN
		}

		return $this->result['error'];

	}
	/**
	 * Create new transaction in memcached if last not exist
	 *
	 */
	private function _startTransaction(){
		return 1;
	}

	/**
	 * Reset transaction in memcached if Register Success or Charging Fail
	 *
	 */
	private function _finishTransaction(){

	}

	/**
	 * Update Activity
	 */
	private function _success() {
		$smsClient = new SmsClient();
                if($this->params['send_now'] == 1){
                    $content = Yii::t('web', "Ban da gui tang SDT {toPhone} mon qua {songName} (MBH: {songCode}) co ma qua tang {giftId}. Se co thong bao cho ban khi mon qua duoc gui tang thanh cong. Moi ban goi den 9234 nhanh so 3 va lam theo HD de nghe lai qua da tang!"
						, array('{toPhone}' => $this->params['to_phone'],
								'{songName}' => $this->songObj->name,
								'{songCode}' => $this->songObj->code,
								'{giftId}' => $this->giftId));
                }else{
                    $content = Yii::t('web', 'Ban da gui tang SDT {toPhone} mon qua {songName} (MBH: {songCode}) co ma qua tang {giftId}. Goi 9234 neu ban muon chinh sua thong tin QT. Cam on ban da su dung dich vu!'
							, array('{toPhone}' => $this->params['to_phone'],
								'{songName}' => $this->songObj->name,
								'{songCode}' => $this->songObj->code,
								'{giftId}' => $this->giftId));
                }
		$receiver 		=  $this->params['msisdn'];
		$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
		$res = $smsClient->sentMT("9234", $receiver, 0, $content, 0, "", $smsId, 9234);
	}

	/**
	 * Log error
	 */
	private function _error(){
		//error here
	}
}
