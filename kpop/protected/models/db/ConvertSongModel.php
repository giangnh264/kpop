<?php
class ConvertSongModel extends BaseConvertSongModel
{
	const STATUS_NEW = 0;
	const STATUS_PROCESSING = 1;
	const STATUS_SUCCESS = 2;
	const STATUS_FAILED = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConvertSong the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}