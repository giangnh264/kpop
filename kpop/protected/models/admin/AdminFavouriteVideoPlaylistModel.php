<?php

Yii::import('application.models.db.FavouriteVideoPlaylistModel');

class AdminFavouriteVideoPlaylistModel extends FavouriteVideoPlaylistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}