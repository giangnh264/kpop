<?php
class RefunContentModel extends BaseRefunContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RefunContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function checkExist($phone, $action = 'download_song')
	{
		$c = new CDbCriteria();
		$c->condition = "created_time >= date_sub(now(), interval 24 hour) AND phone=:PHONE AND action=:ACT";
		$c->params = array(':PHONE'=>$phone,':ACT'=>$action);
		$count = self::model()->count($c);
		if($count > 0)
		 return true;
		return false;
		
	}
}