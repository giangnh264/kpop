<?php

Yii::import('application.models.db.UserAccountModel');

class AdminUserAccountModel extends UserAccountModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}