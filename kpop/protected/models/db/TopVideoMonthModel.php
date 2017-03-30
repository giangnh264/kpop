<?php
class TopVideoMonthModel extends BaseTopVideoMonthModel
{
	const ACTIVE = 1;
	const DECTIVE = 0;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopVideoMonth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}