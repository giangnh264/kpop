<?php

Yii::import('application.models.db.StatisticNewsModel');

class AdminStatisticNewsModel extends StatisticNewsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}