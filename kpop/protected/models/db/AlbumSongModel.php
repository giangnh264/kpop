<?php
class AlbumSongModel extends BaseAlbumSongModel
{
	const ACTIVE = 1;
	const DEATIVE = 0;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function relations(){

		return CMap::mergeArray(parent::relations(),array(
			'song'			=> array(self::BELONGS_TO, 'SongModel', 'song_id'),
			'album'			=> array(self::BELONGS_TO, 'AlbumModel', 'album_id'),
		));
	}
}