<?php
abstract class BaseWatchVideo extends BaseBusiness {
	protected $videoObj;
	public function doWatchVideo() {
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
		//set Params for logging
		$this->params['cmd'] = Yii::app()->params['cmd.video.play'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction
		
		//return ERROR if params invalided
		if (!(($this->params['msisdn']) &&
              ($this->params['itemCode']) &&     //Code
              (isset($this->params['source'])))
           	){
            $this->result['error'] = 'invalid_params';                                  
            return $this->result['error'];
        }   

        
		//get video Object
		$this->videoObj = BmVideoModel::model()->getVideoByCode($this->params['itemCode']);
		if ($this->videoObj) {
			$this->result['error'] =  $this->defineBiz();  //0 
		}else {
			$this->result['error'] = 'video_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error']; 
		}
        bmCommon::logFile('['.$this->params['msisdn'].'][play video]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']','userActivity','play');
		//save activity
		try {
            //log Db
            BmUserActivityModel::model()->add($this->params);
			//log to gamification
			/*if($this->userSubscribe){
				try {
					$params = $this->params;
					$userId = isset($params['user_id']) ? $params['user_id'] : 0;
					$data = array(
						'msisdn' => $params['msisdn'],
						'user_id' => $userId,
						'source' => $params["source"],
						'transaction' => 'play_video',
						'content_id' => $this->videoObj->id,
						'content_name'=>$params['obj1_name'],
						'log_point'=> 1,
					);
					$paramsGM = array(
						"params" => $data
					);
					$resGM = Yii::app()->gearman->client()->doBackground('doLogGami', json_encode($paramsGM));


				}catch (Exception $e)
				{
					//$e->getMessage();
				}
			}*/

        }
        catch (Exception $e)
        {
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'play_video');
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
            $this->result['error'] = 'transaction_forbidden';                
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
		//log user_activity if success
	}

	/**
	 * Log error
	 */
	private function _error(){
		//error here
	}
}