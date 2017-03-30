<?php

class LogUrlReturnModel extends BaseLogUrlReturnModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogUrlReturn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function addLog($params = array())
	{
		try {
			$obj = new self();
			$obj->msisdn = isset($params['msisdn'])?$params['msisdn']:"";
			$obj->user_ip = isset($params['user_ip'])?$params['user_ip']:"";
			$obj->user_agent = isset($params['user_agent'])?$params['user_agent']:"";
			$obj->device_id = isset($params['device_id'])?$params['device_id']:"";
			$obj->action = isset($params['action'])?$params['action']:"";
			$obj->return_url = isset($params['return_url'])?$params['return_url']:"";
			$obj->obj_id = isset($params['obj_id'])?$params['obj_id']:"";
			$obj->channel = isset($params['channel'])?$params['channel']:"wap";
			$obj->created_time = new CDbExpression("NOW()");
			$obj->save();
		}catch (Exception $e)
		{

		}
	}
}