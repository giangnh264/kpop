<?php

Yii::import('application.models.db.ImportUserContentModel');

class AdminImportUserContentModel extends ImportUserContentModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}