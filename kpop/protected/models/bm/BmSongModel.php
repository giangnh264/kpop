<?php

Yii::import('application.models.db.SongModel');

class BmSongModel extends SongModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function scopes() {
		return array(
			'published'=>array(
                'condition' => 't.status = '.self::ACTIVE
			),
        );
	}

	public function getSongByCode($code) {
		$criteria = new CDbCriteria();
		$criteria->condition = "code = :CODE";
		$criteria->params = array(
			':CODE' => $code,
		);
		return self::model()->published()->find($criteria);
	}

    /**
     * function getSongsOfAlbum : get the songs that belong to a specified album
     * @param integer $albumId
     * @return array $results
     */
    public function getSongsOfAlbum($albumId)
    {
        $criteria = new CDbCriteria;
        $criteria->alias = "t";
        $criteria->join = "INNER JOIN album_song a ON t.id = a.song_id ";
        $criteria->condition = "a.album_id = :ALBUMID AND a.status=:ALBUMSONGSTATUS";
        $criteria->params = array(':ALBUMID' => $albumId, ":ALBUMSONGSTATUS"=>BmAlbumSongModel::ACTIVE);
        $results = BmSongModel::model()->published()->findAll($criteria);
        return $results;
    }
}