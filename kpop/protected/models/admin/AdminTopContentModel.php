<?php

Yii::import('application.models.db.TopContentModel');

class AdminTopContentModel extends TopContentModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}