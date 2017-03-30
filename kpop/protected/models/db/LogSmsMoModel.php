<?php
class LogSmsMoModel extends BaseLogSmsMoModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogSmsMo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_sms_mo';
	}
	
	function logMo($username,$password,$service_number,$sender,$content,$keyword,$first_param,$last_param,$sms_id,$smsc)
	{
		$obj = new self();
		$obj->service_number = $service_number;
		$obj->sms_id = $sms_id;
		$obj->sender_phone = $sender;
		$obj->receive_time = date("Y-m-d H:i:s");
		$obj->keyword = $keyword;
		$obj->content = $content;
		$obj->auth_user = $username;
		$obj->auth_pass = $password;
		$obj->save();
		return $obj;
	}
}