<?php

class MgChannelSongModel extends BaseMgChannelSongModel {

    /**
     * Returns the static model of the specified AR class.
     * @return MgChannelSong the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            "song" => array(self::BELONGS_TO, "SongModel", "song_id", "joinType" => "INNER JOIN"),
        );
    }

}