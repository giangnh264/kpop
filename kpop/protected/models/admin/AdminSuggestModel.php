<?php

Yii::import('application.models.db.SuggestModel');

class AdminSuggestModel extends SuggestModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}