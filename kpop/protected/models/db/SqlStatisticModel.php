<?php
class SqlStatisticModel extends BaseSqlStatisticModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SqlStatistic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}