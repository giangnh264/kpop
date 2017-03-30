<?php
class RingtoneStatusModel extends BaseRingtoneStatusModel
{
	const NOT_CONVERT = 0;
	const CONVERT_SUCCESS = 1;
	const CONVERT_FAIL = 2;
	const WAIT_APPROVED= 0;
	const APPROVED= 1;
	const REJECT= 2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return RingtoneStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}