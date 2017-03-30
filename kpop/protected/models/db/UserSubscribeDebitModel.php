<?php
class UserSubscribeDebitModel extends BaseUserSubscribeDebitModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribeDebit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function addNew($userPhone,$packageId)
	{
		$subsDebitModel = new self();
		$subsDebitModel->user_phone = $userPhone;
		$subsDebitModel->created_time = new CDbExpression("NOW()");
		$subsDebitModel->updated_time = new CDbExpression("NOW()");
		$subsDebitModel->package_id = $packageId;
		$subsDebitModel->save();
		return $subsDebitModel; 
	}
	
	public function subs_exists($userPhone,$inMonth = false)
	{
		$c = new CDbCriteria();
		if($inMonth){
			$c->condition = "user_phone=:PHONE AND updated_time >= date_sub(now(), interval 720 hour)";
		}else{
			$c->condition = "user_phone=:PHONE";			
		}
		$c->params = array(":PHONE"=>$userPhone);
		return self::model()->find($c);
	}
	
}