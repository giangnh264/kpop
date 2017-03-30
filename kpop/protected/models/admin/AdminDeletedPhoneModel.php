<?php

Yii::import('application.models.db.DeletedPhoneModel');

class AdminDeletedPhoneModel extends DeletedPhoneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}