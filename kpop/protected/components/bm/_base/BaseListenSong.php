<?php
abstract class BaseListenSong extends BaseBusiness {
	protected $songObj;
	public function doListenSong() {
        if ($this->_prepare() == 'success') {  
            if ($this->_doBiz() == 'success') { 
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

		//prepare Params for execute
		$this->params['cmd'] = Yii::app()->params['cmd.song.listen'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction

		if (!(($this->params['msisdn']) &&
              ($this->params['itemCode']) &&     //Code
              (isset($this->params['source'])))
           	){
            $this->result['error'] = 'invalid_params';                                  
            return $this->result['error'];
        }   
		//get Song Object
        
		$this->songObj = BmSongModel::model()->getSongByCode($this->params['itemCode']);
		if ($this->songObj) {
			$this->result['error'] =  $this->defineBiz();  
		}else {
			$this->result['error'] = 'song_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error']; 
		}
        bmCommon::logFile('['.$this->params['msisdn'].'][play song]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']','userActivity','song');
		//save activity
		try {
            //log Db
            BmUserActivityModel::model()->add($this->params);
			/*//log to gamification
			if($this->userSubscribe){
				try {
					$params = $this->params;
					$userId = isset($params['user_id']) ? $params['user_id'] : 0;
					$data = array(
						'msisdn' => $params['msisdn'],
						'user_id' => $userId,
						'source' => $params["source"],
						'transaction' => 'play_song',
						'content_id' => $this->songObj->id,
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
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'play_song');
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
		//log user_activity if success
		// can send SMS here
		$songObj = SongModel::model()->findByAttributes(array('code'=>$this->params['itemCode']));
		$cacheId = $this->params['msisdn']."-play_song-".$songObj->id;
		Yii::app()->cache->set($cacheId, "OK", 86400);
		
	}

	/**
	 * Log error
	 */
	private function _error(){
		//error here
	}
}