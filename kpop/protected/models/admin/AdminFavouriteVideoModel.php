<?php

Yii::import('application.models.db.FavouriteVideoModel');

class AdminFavouriteVideoModel extends FavouriteVideoModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'video'=>array(self::BELONGS_TO, 'AdminVideoModel', 'video_id', 'select'=>'id, name', 'joinType'=>"INNER JOIN"),
            'user'=>array(self::BELONGS_TO, 'AdminUserModel', 'user_id', 'select'=>'id, username', 'joinType'=>"INNER JOIN"),
        ));
    }
}