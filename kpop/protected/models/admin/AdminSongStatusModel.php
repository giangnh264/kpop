<?php

Yii::import('application.models.db.SongStatusModel');

class AdminSongStatusModel extends SongStatusModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}