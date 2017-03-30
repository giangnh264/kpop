<?php

Yii::import('application.models.db.UserSubscribePendingModel');

class AdminUserSubscribePendingModel extends UserSubscribePendingModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}