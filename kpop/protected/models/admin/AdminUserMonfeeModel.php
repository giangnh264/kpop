<?php

Yii::import('application.models.db.UserMonfeeModel');

class AdminUserMonfeeModel extends UserMonfeeModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}