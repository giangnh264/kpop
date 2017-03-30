<?php

Yii::import('application.models.db.FeaturePlaylistModel');

class AdminFeaturePlaylistModel extends FeaturePlaylistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'playlist'=>array(self::BELONGS_TO, 'AdminPlaylistModel', 'playlist_id', 'select'=>'id, name'),
            'admin'=>array(self::BELONGS_TO, 'AdminAdminUserModel', 'created_by', 'select'=>'id, username'),
        ));
    }    
}