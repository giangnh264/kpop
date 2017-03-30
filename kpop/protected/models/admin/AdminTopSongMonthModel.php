<?php

Yii::import('application.models.db.TopSongMonthModel');

class AdminTopSongMonthModel extends TopSongMonthModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}