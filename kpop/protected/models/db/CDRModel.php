<?php

class CDRModel extends BaseCDRModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CDR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function logCDR($params) {
		$cdr = new self();
		$cdr->CREATED_TIME = $params['created_time'];
		$cdr->MSISDN = $params['msisdn'];
		$cdr->SHORT_CODE = isset($params['short_code'])?$params['short_code']:0;
		$cdr->CATEGORY_ID = $params['category_id'];
		$cdr->CP_ID = $params['cp_id'];
		$cdr->CONTENT_ID = $params['content_id'];
		$cdr->COST = $params['cost'];
		$cdr->CHANNEL_TYPE = $params['channel_type'];
		$cdr->INFORMATION = $params['information'];
		$cdr->STATUS = $params['status'];
	
		if ($cdr->save(false)) return true;
		else return false;
	
	}
	
	public function getAllCDR() {
		$criteria = new CDbCriteria;
		$criteria->alias = 'c';
		$criteria->select = "*";
		$criteria->condition = "MSISDN != 'N/A' AND IS_SEND = 0";
		$criteria->order = "CREATED_TIME DESC";
	
		$data = self::model()->findAll($criteria);
	
		return $data;
	}
}