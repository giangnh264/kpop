<?php

Yii::import('application.models.db.LogUrlReturnModel');

class AdminLogUrlReturnModel extends LogUrlReturnModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}