<?php
class FavouriteAlbumModel extends BaseFavouriteAlbumModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FavouriteAlbum the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	/**
	 * @return array relational rules.
	 */
	/* public function relations(){
		return CMap::mergeArray(parent::relations(), array(
				"album"=> array(self::BELONGS_TO, "AlbumModel", "album_id"),
				"user"=> array(self::BELONGS_TO, "UserModel", "user_id"),
		));
	} */
}