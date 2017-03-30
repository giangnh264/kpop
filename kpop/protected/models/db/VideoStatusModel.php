<?php
class VideoStatusModel extends BaseVideoStatusModel
{
	const NOT_CONVERT = 0;
	const CONVERT_SUCCESS = 1;
	const CONVERT_FAIL = 2;
	const WAIT_APPROVED= 0;
	const APPROVED= 1;
	const REJECT= 2;
	const DELETED= 3;
	const ARTIST_PUBLISH = 1;
	const ARTIST_UNPUBLISH = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}