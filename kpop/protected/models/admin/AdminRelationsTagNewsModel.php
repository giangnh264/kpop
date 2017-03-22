<?php

Yii::import('application.models.db.RelationsTagNewsModel');

class AdminRelationsTagNewsModel extends RelationsTagNewsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}