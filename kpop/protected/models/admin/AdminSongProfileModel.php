<?php

Yii::import('application.models.db.SongProfileModel');

class AdminSongProfileModel extends SongProfileModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}