<?php

Yii::import('application.models.db.VservPostBackModel');

class AdminVservPostBackModel extends VservPostBackModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}