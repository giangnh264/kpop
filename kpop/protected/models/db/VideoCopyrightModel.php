<?php

class VideoCopyrightModel extends BaseVideoCopyrightModel {

    /**
     * Returns the static model of the specified AR class.
     * @return VideoCopyright the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'copyr' => array(self::BELONGS_TO, 'AdminCopyrightModel', 'copryright_id'),
                    'video' => array(self::BELONGS_TO, 'AdminVideoModel', 'video_id'),
                ));
    }

}