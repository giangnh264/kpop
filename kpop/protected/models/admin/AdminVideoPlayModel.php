<?php

Yii::import('application.models.db.VideoPlayModel');

class AdminVideoPlayModel extends VideoPlayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}