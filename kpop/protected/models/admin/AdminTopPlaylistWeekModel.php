<?php

Yii::import('application.models.db.TopPlaylistWeekModel');

class AdminTopPlaylistWeekModel extends TopPlaylistWeekModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}