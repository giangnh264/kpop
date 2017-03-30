<?php

Yii::import('application.models.db.EmailQueueModel');

class AdminEmailQueueModel extends EmailQueueModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}