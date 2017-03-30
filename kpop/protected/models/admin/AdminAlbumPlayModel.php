<?php

Yii::import('application.models.db.AlbumPlayModel');

class AdminAlbumPlayModel extends AlbumPlayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}