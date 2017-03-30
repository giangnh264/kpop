<?php

Yii::import('application.models.db.TopSongDayModel');

class AdminTopSongDayModel extends TopSongDayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}