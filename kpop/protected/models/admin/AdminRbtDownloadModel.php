<?php

Yii::import('application.models.db.RbtDownloadModel');

class AdminRbtDownloadModel extends RbtDownloadModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}