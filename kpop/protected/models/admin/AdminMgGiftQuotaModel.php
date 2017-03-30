<?php

Yii::import('application.models.db.MgGiftQuotaModel');

class AdminMgGiftQuotaModel extends MgGiftQuotaModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}