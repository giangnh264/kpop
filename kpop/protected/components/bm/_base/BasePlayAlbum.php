<?php
abstract class BasePlayAlbum extends BaseBusiness {
	protected $albumObj;
	public function doPlayAlbum() {
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
	 * Get album, price, quota
	 * Define Business
	 * @return 0 if success, others if not
	 */
	private function  _prepare() {

		//prepare Params for execute
		$this->params['cmd'] = Yii::app()->params['cmd.album.play'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction

		if (!(($this->params['msisdn']) &&
              ($this->params['itemCode']) &&     //Code
              (isset($this->params['source'])))
           	){
            $this->result['error'] = 'invalid_params';
            return $this->result['error'];
        }
		//get Album Object

		$this->albumObj = BmAlbumModel::model()->published()->findByPk($this->params['itemCode']);
		if ($this->albumObj) {
			$this->result['error'] =  $this->defineBiz();
		}else {
			$this->result['error'] = 'album_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error'];
		}
        bmCommon::logFile('['.$this->params['msisdn'].'][play album]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']','userActivity','album');
		//save activity
		try
        {
            //log Db
            BmUserActivityModel::model()->add($this->params);
        }
        catch (Exception $e){
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'play_album');
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
	}

	/**
	 * Log error
	 */
	private function _error(){
		//error here
	}
}