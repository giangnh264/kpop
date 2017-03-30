<?php

class LogAdsClickModel extends BaseLogAdsClickModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogAdsClick the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function logAdsWap($phone, $source = 'BUZZCITY', $user_ip, $is3G = 0){
		$this->ads = $source;
		$this->user_phone = $phone;
		$this->user_ip = $user_ip;
        $this->is_3g = $is3G;
		$this->created_time = date("Y-m-d H:i:s");
		$result = $this->save();
		return $result;
		
	}
}