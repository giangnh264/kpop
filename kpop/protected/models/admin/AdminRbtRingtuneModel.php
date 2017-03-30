<?php

Yii::import('application.models.db.RbtRingtuneModel');

class AdminRbtRingtuneModel extends RbtRingtuneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}