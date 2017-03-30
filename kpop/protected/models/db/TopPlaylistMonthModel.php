<?php
class TopPlaylistMonthModel extends BaseTopPlaylistMonthModel
{
	const ACTIVE = 1;
	const DECTIVE = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopPlaylistMonth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}