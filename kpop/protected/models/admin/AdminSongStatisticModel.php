<?php

Yii::import('application.models.db.SongStatisticModel');

class AdminSongStatisticModel extends SongStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}