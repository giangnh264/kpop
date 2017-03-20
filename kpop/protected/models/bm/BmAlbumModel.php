<?php
/*
 * @author : longtv
 *
 */
class BmAlbumModel extends AlbumModel
{
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
	}

    public function relations()
    {
		return CMap::mergeArray(parent::relations(),array(
			"album_song"		=> array(self::HAS_ONE, "WapAlbumSongModel", "album_id"),
			"songs"				=> array(self::MANY_MANY, "WapSongModel", "album_song(album_id, song_id)"),
			"song_statistic"	=> array(self::HAS_ONE, "WapSongStatisticModel", "id", "through" => "songs"),
			//"album_statistic"	=> array(self::HAS_ONE, "WapAlbumStatisticModel", "album_id")
            //"song_statistic" => array(self::HAS_ONE, "SongStatisticModel", "song_id"),
		));
	}

    public function scopes()
    {
		return array(
			"published"	=> array(
				"condition"	=> "`t`.`status` = ".self::ACTIVE,
			),
		);
	}    

    /**
	 *
	 * function getThumbnailUrl : get url of album thumbnail
	 * @param string $size s1 s2 s3 s4 s5
	 * @param int $artist_id
	 */
	public function getThumbnailUrl($size, $album_id=null)
    {
		return AvatarHelper::getAvatar("album", $album_id ? $album_id:$this->id, $size);
	}
}
?>
