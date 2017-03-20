<?php

/**
 * Lop active record danh cho cac noi dung: song, video, album, playlist, ringtone, rbt
 */
class MainContentModel extends MainActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Album the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


}

?>