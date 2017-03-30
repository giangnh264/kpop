<?php

Yii::import('application.models.db.TextLinkModel');

class AdminTextLinkModel extends TextLinkModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}