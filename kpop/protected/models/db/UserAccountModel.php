<?php
class UserAccountModel extends BaseUserAccountModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}