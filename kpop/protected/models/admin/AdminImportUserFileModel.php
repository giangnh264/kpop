<?php

Yii::import('application.models.db.ImportUserFileModel');

class AdminImportUserFileModel extends ImportUserFileModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}