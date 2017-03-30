<?php

class LogApiProviderModel extends BaseLogApiProviderModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogApiProvider the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function log($params=array())
	{
		$log = new self();
		$log->loged_time = new CDbExpression("NOW()");
		$log->client_ip = isset($params['client_ip'])?$params['client_ip']:"";
		$log->service_name = isset($params['service_name'])?$params['service_name']:"";
		$log->service_url = isset($params['service_url'])?$params['service_url']:"";
		$log->request_params = isset($params['request_params'])?$params['request_params']:"";
		$log->protocol = isset($params['protocol'])?$params['protocol']:"";
		$log->start_time = isset($params['start_time'])?$params['start_time']:"";
		$log->end_time = isset($params['end_time'])?$params['end_time']:"";
		$log->execute_time = strtotime($params['end_time']) - strtotime($params['start_time']);
		$log->response = isset($params['response'])?$params['response']:"";
		$ret = $log->save();
		if(!$ret)
		{
		}
	}
}