<?php

Yii::import('application.models.db.ApiObjectModel');

class AdminApiObjectModel extends ApiObjectModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}