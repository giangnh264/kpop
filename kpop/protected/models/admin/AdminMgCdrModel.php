<?php

Yii::import('application.models.db.MgCdrModel');

class AdminMgCdrModel extends MgCdrModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}