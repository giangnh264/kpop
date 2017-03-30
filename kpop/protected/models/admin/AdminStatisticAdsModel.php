<?php

Yii::import('application.models.db.StatisticAdsModel');

class AdminStatisticAdsModel extends StatisticAdsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}