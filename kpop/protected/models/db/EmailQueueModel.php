<?php
class EmailQueueModel extends BaseEmailQueueModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmailQueue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}