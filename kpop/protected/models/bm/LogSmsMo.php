<?php

Yii::import('application.models.db.LogSmsMoModel');

class LogSmsMo extends LogSmsMoModel
{	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function add($params) {
		$logMo = new LogSmsMo();
		$logMo->service_number = $params['service_number'];
		$logMo->sms_id = $params['sms_id'];
		$logMo->sender_phone = $params['msisdn'];
		$logMo->receive_time = $params['createdDatetime'];
		$logMo->keyword = $params['keyword'];
		$logMo->content = $params['content'];
		$logMo->auth_user = $params['auth_user'];
		$logMo->auth_pass = $params['auth_pass']; 
		$logMo->output_id = $params['output_id'];
		$logMo->status = $params['status'];
		$logMo->save();
	}
}