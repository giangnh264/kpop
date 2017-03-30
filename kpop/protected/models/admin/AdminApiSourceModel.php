<?php

Yii::import('application.models.db.ApiSourceModel');

class AdminApiSourceModel extends ApiSourceModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}