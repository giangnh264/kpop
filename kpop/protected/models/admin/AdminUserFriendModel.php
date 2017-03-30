<?php

Yii::import('application.models.db.UserFriendModel');

class AdminUserFriendModel extends UserFriendModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}