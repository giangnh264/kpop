<?php

Yii::import('application.models.db.TagContentModel');

class AdminTagContentModel extends TagContentModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}