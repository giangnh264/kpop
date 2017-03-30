<?php

Yii::import('application.models.db.UserChargeRemainModel');

class AdminUserChargeRemainModel extends UserChargeRemainModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}