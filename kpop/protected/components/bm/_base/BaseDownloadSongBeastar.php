<?php
abstract class BaseDownloadSongBeastar extends BaseBusiness {
	
	protected $songObj;
	public function doDownloadSongBeastar() {
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
		$this->params['cmd'] = Yii::app()->params['cmd.song.download'];
		$this->params['obj2_name'] = $this->params['to_phone'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction
		$this->params['send_sms'] = 'not_send';
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
        bmCommon::logFile('['.$this->params['msisdn'].'][download song beastar]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']'.$this->params['source'],'userActivity','download');

        //save activity
		try {
            //log Db
            BmUserActivityModel::model()->add($this->params);
        } 
        catch (Exception $e)
        {
            //add log file
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'download_song_beastar');
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
        
            $this->result['error'] = Transaction::doChargeContent($this->params);
			
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
		
		if (!isset($this->params['send_sms'])){
			if($this->params['msisdn'] != $this->params['to_phone']) {
				 //send song
				 //$description = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendSong']['desc'], array('{FROMPHONE}'=>$this->params['msisdn'], '{SONG_NAME}'=>$this->songObj->name));
				 $content  = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendSong']['content'], array('{FROMPHONE}'=>$this->params['msisdn'], '{SONG_NAME}'=>$this->songObj->name, '{SONG_ID}'=>$this->songObj->id));
			} else { //download song
				$content	 = Yii::t('bm',Yii::app()->params['sms.messageMT']['downloadSong']['content'], array('{SONG_NAME}'=>$this->songObj->name, '{SONG_ID}'=>$this->songObj->id));
				//$description = Yii::t('bm',Yii::app()->params['sms.messageMT']['downloadSong']['desc'], array('{SONG_NAME}'=>$this->songObj->name));
			}
			
			//set for send MT
    		$serviceNumber  = Yii::app()->params['sms.sendMT']['serviceNumber'];
    		$receiver 		= ($this->params['msisdn'] != $this->params['to_phone'])? $this->params['to_phone']: $this->params['msisdn'];
			$msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
			$charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
			//$description 	= $description;
			$description = '';
            $smsId 			= time();
			$smsc	= Yii::app()->params['sms.sendMT']['serviceNumber'];
			
			$smsClient = new SmsClient();
            $ret = $smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);            
            bmCommon::logFile($ret,'sendMT','download_song');

            if ($this->params['msisdn'] != $this->params['to_phone'])
            {
                $receiver 		=  $this->params['msisdn'];
                $msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
                $charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
                $description 	= '';
                $smsId 			= time();
                $content = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendSongSuccess']['content'], array('{TOPHONE}'=>$this->params['to_phone']));
                $smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);
            }
		}
	}

	/**
	 * Log error
	 */
	private function _error(){
		//error here
		if (!isset($this->params['send_sms']) && $this->result['error'] != 'invalid_params'){
			
			if (isset(Yii::app()->params['downloadSong'][$this->result['error']])){
                $content = Yii::app()->params['downloadSong'][$this->result['error']]; // get Message by errorCode
            }else{
            	$content = Yii::app()->params['downloadSong']['default'];
            }
        	//set for send MT
			$serviceNumber  = Yii::app()->params['sms.sendMT']['serviceNumber'];
			$receiver 		=  bmCommon::formatMSISDN($this->params['msisdn']);
			$msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
			$charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
			$description 	= "";
			$smsId 			= time();
			$smsc	= Yii::app()->params['sms.sendMT']['serviceNumber'];
			
			$smsClient = new SmsClient();
	 		$smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);
		
		}
	}
}