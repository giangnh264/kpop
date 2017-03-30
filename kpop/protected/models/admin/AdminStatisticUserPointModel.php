<?php

Yii::import('application.models.db.StatisticUserPointModel');

class AdminStatisticUserPointModel extends StatisticUserPointModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}