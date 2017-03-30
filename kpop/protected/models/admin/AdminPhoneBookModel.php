<?php

Yii::import('application.models.db.PhoneBookModel');

class AdminPhoneBookModel extends PhoneBookModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}