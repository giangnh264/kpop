<?php

Yii::import('application.models.db.AlbumExtraModel');

class AdminAlbumExtraModel extends AlbumExtraModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}