<?php
class TopSongDayModel extends BaseTopSongDayModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopSongDay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}