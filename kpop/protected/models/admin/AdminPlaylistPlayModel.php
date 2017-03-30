<?php

Yii::import('application.models.db.PlaylistPlayModel');

class AdminPlaylistPlayModel extends PlaylistPlayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}