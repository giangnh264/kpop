<?php
class AlbumPlayModel extends BaseAlbumPlayModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * return primaryKey name
     */
    public function primaryKey()
    {
        return "id";
    }
}