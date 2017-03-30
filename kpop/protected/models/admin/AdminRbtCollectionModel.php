<?php

Yii::import('application.models.db.RbtCollectionModel');

class AdminRbtCollectionModel extends RbtCollectionModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}