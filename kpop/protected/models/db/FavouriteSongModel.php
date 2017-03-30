<?php
class FavouriteSongModel extends BaseFavouriteSongModel {

    /**
     * Returns the static model of the specified AR class.
     * @return FavouriteSong the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
		return CMap::mergeArray(parent::relations(), array(
			"song"=> array(self::BELONGS_TO, "SongModel", "song_id"),
			"user"=> array(self::BELONGS_TO, "UserModel", "msisdn"),
		));
	}

    public function findAllByUser($msisdn, $limit, $offset) {
        $criteria = new CDbCriteria();
        $criteria->condition = "msisdn=:user_id";
        $criteria->params = array(":user_id" => $msisdn);
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        $criteria->order = "t.created_time DESC";
        $fsongs = $this->with("song")->findAll($criteria);
        $songs = array();
        foreach ($fsongs as $fsong) {
            $songs[] = $fsong->song;
        }
        return $songs;
    }

}