<?php
class ArtistFanModel extends BaseArtistFanModel
{
	const ACTIVE = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ArtistFan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}