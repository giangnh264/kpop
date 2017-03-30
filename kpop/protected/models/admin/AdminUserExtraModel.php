<?php

Yii::import('application.models.db.UserExtraModel');

class AdminUserExtraModel extends UserExtraModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}