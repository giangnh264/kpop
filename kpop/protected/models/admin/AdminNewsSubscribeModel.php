<?php

Yii::import('application.models.db.NewsSubscribeModel');

class AdminNewsSubscribeModel extends NewsSubscribeModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}