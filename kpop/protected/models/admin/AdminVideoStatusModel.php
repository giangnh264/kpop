<?php

Yii::import('application.models.db.VideoStatusModel');

class AdminVideoStatusModel extends VideoStatusModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}