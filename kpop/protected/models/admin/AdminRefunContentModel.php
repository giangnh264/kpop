<?php

Yii::import('application.models.db.RefunContentModel');

class AdminRefunContentModel extends RefunContentModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}