<?php

Yii::import('application.models.db.UserVipModel');

class AdminUserVipModel extends UserVipModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}