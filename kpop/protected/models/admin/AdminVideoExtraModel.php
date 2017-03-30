<?php

Yii::import('application.models.db.VideoExtraModel');

class AdminVideoExtraModel extends VideoExtraModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}