<?php
class UserVerifyModel extends BaseUserVerifyModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserVerify the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function checkOtp($msisdn, $action){
		$cr = new CDbCriteria();
		$cr->condition = 'msisdn = :USER_PHONE AND action = :ACTION AND created_time > :CREATE_TIME';
		$cr->params = array(":USER_PHONE"=>$msisdn, ":ACTION"=>$action, ":CREATE_TIME"=>date("Y-m-d H:i:s", (time()-86400 )));
		$count = UserVerifyModel::model()->count($cr);
		if($count >= 3){
			return false;
		}
		else return true;
	}
	
	public function getLastestOtp($msisdn, $action){
		$cr = new CDbCriteria();
		$cr->condition = 'msisdn = :USER_PHONE AND action = :ACTION';
		$cr->params = array(":USER_PHONE"=>$msisdn, ":ACTION"=>$action);
		$cr->limit = 1;
		$cr->order = "id DESC";
		$return = UserVerifyModel::model()->find($cr);
		return $return;
	}
}