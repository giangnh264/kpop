<?php

class CollectionItemModel extends BaseCollectionItemModel {

    /**
     * Returns the static model of the specified AR class.
     * @return CollectionItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "song" => array(self::BELONGS_TO, "SongModel", "item_id"),
            "video" => array(self::BELONGS_TO, "VideoModel", "item_id"),
            "album" => array(self::BELONGS_TO, "AlbumModel", "item_id"),
            "playlist" => array(self::BELONGS_TO, "PlaylistModel", "item_id"),
            "rbt" => array(self::BELONGS_TO, "RbtModel", "item_id"),
            "rt" => array(self::BELONGS_TO, "RingtoneModel", "item_id"),
            "video_playlist" => array(self::BELONGS_TO, "VideoPlaylistModel", "item_id"),
        );
    }

}