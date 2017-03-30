<?php

Yii::import('application.models.db.SongExtraModel');

class AdminSongExtraModel extends SongExtraModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}