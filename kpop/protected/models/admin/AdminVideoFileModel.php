<?php

Yii::import('application.models.db.VideoFileModel');

class AdminVideoFileModel extends VideoFileModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}