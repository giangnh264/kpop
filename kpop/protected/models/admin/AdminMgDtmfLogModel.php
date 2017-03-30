<?php

Yii::import('application.models.db.MgDtmfLogModel');

class AdminMgDtmfLogModel extends MgDtmfLogModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}