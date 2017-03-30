<?php

Yii::import('application.models.db.UserSettingModel');

class AdminUserSettingModel extends UserSettingModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}