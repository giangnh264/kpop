<?php
class CpModel extends BaseCpModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}