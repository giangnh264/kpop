<?php
class UserQuotaModel extends BaseUserQuotaModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserQuota the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}