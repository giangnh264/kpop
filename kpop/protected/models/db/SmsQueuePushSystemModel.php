<?php

class SmsQueuePushSystemModel extends BaseSmsQueuePushSystemModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SmsQueuePushSystem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function setPushSMSQueue($sender,$receiver,$smscontent,$sendtime='',$action='', $note='')
	{
		$sender = Formatter::formatPhone($sender);
		$receiver = Formatter::formatPhone($receiver);
		$model = new self();
		$model->sender = $sender;
		$model->receiver = $receiver;
		$model->sms_content = $smscontent;
		$model->send_time = empty($sendtime)?date('Y-m-d H:i:s'):$sendtime;
		$model->action = $action;
		$model->created_time = date('Y-m-d H:i:s');
		$model->note = $note;
		return $model->save();
	}
	public static function updatePushSMS($id, $status=1)
	{
		$model = self::model()->findByPk($id);
		$model->status = $status;
		return $model->save();
	}
	public static function getListToPush($limit=200)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = "status=0 AND send_time<=NOW()";
		$criteria->order = "id ASC";
		$criteria->limit = $limit;
		return self::model()->findAll($criteria);
	}
}