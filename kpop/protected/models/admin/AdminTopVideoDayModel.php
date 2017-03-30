<?php

Yii::import('application.models.db.TopVideoDayModel');

class AdminTopVideoDayModel extends TopVideoDayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}