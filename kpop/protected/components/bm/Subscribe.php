<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subscribe
 *
 * @author 
 */
class Subscribe extends BaseSubscribe{

    /**
     *
     * @return success if allow register, others not allow
     */
	protected function defineBiz() {
		//already have account
		$regPackageId = $this->packageObj->id;
		$this->params['packageId']= $regPackageId; //get id
		$this->params['bundle'] = $this->packageObj->bundle; //bundle
		$this->params['msisdn'] = $this->params['msisdn'];

		//tham so nay quy dinh viec update goi cuoc moi hay giu nguyen goi cuoc hien tai khi luu DB
		$this->params['changePackage'] = true;

		if ($this->userSubscribe){
			$usStatus = $this->userSubscribe->status;
			// xu ly truong hop thue bao dang active
			if ($usStatus == BmUserSubscribeModel::ACTIVE) {
				// neu dang ky trung goi cuoc dang active: thong bao trung goi cuoc
				$message = 'duplicate_package';
				$exitsPackage = PackageModel::model()->findByPk($this->userSubscribe->package_id);
				if(!empty($exitsPackage)){
					$message = 'duplicate_package_'.strtolower($exitsPackage->code);
				}
				return  array('error'=>3,'message'=>$message);
			}
		}

        $this->params['curlType'] = 3;

        // default price and expired_time
        $this->params['price'] = $this->packageObj->fee;
        $this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), $this->packageObj->duration);
        $this->params['originPrice'] = $this->packageObj->fee;
		$this->params['charging'] = ($this->packageObj->owner == "SELF")?1:0;
        
		//promotion
		$freeDay = 0;
		//$trialValue = intval($this->params['promotion']); // ex: 1c, 7d, 2w, 1m => 1,7,2,1
		$trialValue = intval($this->params["client_options"]["ncycle"]);
		if($trialValue) {
			$type  = strtolower($this->params["client_options"]["type"]);
            switch($type) {
                case 'c':   // khuyen mai N chu ky
                    $freeDay = $this->packageObj->duration * $trialValue;
                    break;
                case 'w':   // khuyen mai N tuan
                    $freeDay = 7 * $trialValue;
                    break;
                case 'm':   // khuyen mai N thang
                    $freeDay = 30 * $trialValue;
                    break;
                case 'd':   // khuyen mai N ngay
                default:    // khuyen mai N ngay
                    $freeDay = $trialValue;
            }
		}
		
		if($freeDay) {
			$this->params['kmtq'] = 1;
			//$this->params['promotion'] = 1;
			if($freeDay==1){
				$this->params['expired_time'] = date("Y-m-d 00:05:05", strtotime("+1 day", strtotime(date('Y-m-d'))));
			}else{
				$this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), $freeDay);
			}
		}
		/*Set lai gia neu truyen len tu client*/		
		
		if(isset($this->params["client_options"]["price"])){
			$this->params['price'] = $this->params["client_options"]["price"];
		}		

		$this->params['note'] = $this->params['charge_note'] = $this->params['event'] = $this->params['note_event'];

		return  array('error'=>0,'message'=>'success');
	}
}

?>
