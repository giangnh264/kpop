<?php

Yii::import('application.models.db.RbtArtistModel');

class AdminRbtArtistModel extends RbtArtistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}