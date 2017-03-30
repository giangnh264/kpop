<?php
class AlbumStatisticModel extends BaseAlbumStatisticModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * return primaryKey name
     */
    public function primaryKey() {
        return "album_id";
    }
}