<?php

Yii::import('application.models.db.RbtCategoryModel');

class AdminRbtCategoryModel extends RbtCategoryModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}