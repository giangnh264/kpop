<?php

Yii::import('application.models.db.UserSubscribeTrialModel');

class AdminUserSubscribeTrialModel extends UserSubscribeTrialModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}