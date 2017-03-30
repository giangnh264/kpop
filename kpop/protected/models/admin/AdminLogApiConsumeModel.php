<?php

Yii::import('application.models.db.LogApiConsumeModel');

class AdminLogApiConsumeModel extends LogApiConsumeModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}