<?php

Yii::import('application.models.db.CcpModel');

class AdminCcpModel extends CcpModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}