<?php
class UserSettingModel extends BaseUserSettingModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSetting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}