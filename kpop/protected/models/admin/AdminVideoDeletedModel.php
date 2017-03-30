<?php

Yii::import('application.models.db.VideoDeletedModel');

class AdminVideoDeletedModel extends VideoDeletedModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}