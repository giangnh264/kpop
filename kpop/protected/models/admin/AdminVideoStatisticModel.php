<?php

Yii::import('application.models.db.VideoStatisticModel');

class AdminVideoStatisticModel extends VideoStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}