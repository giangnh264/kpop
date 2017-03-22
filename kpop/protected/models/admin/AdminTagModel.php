<?php

Yii::import('application.models.db.TagModel');

class AdminTagModel extends TagModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}