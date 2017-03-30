<?php

class VideoPlaylistVideoModel extends BaseVideoPlaylistVideoModel
{
    const ACTIVE = 1;
    const DEATIVE = 0;
    /**
        * Returns the static model of the specified AR class.
        * @return VideoPlaylistVideo the static model class
        */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function relations(){	
        return CMap::mergeArray(parent::relations(), array(
                "videoInfo" => array(self::BELONGS_TO, "WebVideoModel", "video_id"),
            ));
    }
    
    public function delete($videoPlaylistIdList = array())
    {
        //delete record from video_playlist_video
        $c = new CDbCriteria();
        $c->addInCondition("video_playlist_id", $videoPlaylistIdList);
        self::model()->deleteAll($c);
    }
}