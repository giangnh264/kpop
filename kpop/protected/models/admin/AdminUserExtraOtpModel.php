<?php

Yii::import('application.models.db.UserExtraOtpModel');

class AdminUserExtraOtpModel extends UserExtraOtpModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}