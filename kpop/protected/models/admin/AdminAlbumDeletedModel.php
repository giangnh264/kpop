<?php

Yii::import('application.models.db.AlbumDeletedModel');

class AdminAlbumDeletedModel extends AlbumDeletedModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}