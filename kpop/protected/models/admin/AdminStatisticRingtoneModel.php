<?php

Yii::import('application.models.db.StatisticRingtoneModel');

class AdminStatisticRingtoneModel extends StatisticRingtoneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}