<?php

Yii::import('application.models.db.UserModel');

class AdminUserModel extends UserModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}