<?php

Yii::import('application.models.db.NewsModel');

class AdminNewsModel extends NewsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}