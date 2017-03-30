<?php
class UserSubscribePendingModel extends BaseUserSubscribePendingModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribePending the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function add($params = array())
	{
		$uPending = new self();
		$uPending->user_phone = $params['phone'];
		$uPending->action = isset($params['action'])?$params['action']:'pending';
		$uPending->note = isset($params['note'])?$params['note']:''; 
		$uPending->created_time = new CDbExpression("NOW()"); 
		$uPending->save();
	}
}