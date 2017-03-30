<?php

Yii::import('application.models.db.SongPlayModel');

class AdminSongPlayModel extends SongPlayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}