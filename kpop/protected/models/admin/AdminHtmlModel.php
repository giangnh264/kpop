<?php

Yii::import('application.models.db.HtmlModel');

class AdminHtmlModel extends HtmlModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}