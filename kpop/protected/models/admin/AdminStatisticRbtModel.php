<?php

Yii::import('application.models.db.StatisticRbtModel');

class AdminStatisticRbtModel extends StatisticRbtModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}