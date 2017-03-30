<?php
class RbtCategoryModel extends BaseRbtCategoryModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}