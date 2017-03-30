<?php

Yii::import('application.models.db.AlbumStatusModel');

class AdminAlbumStatusModel extends AlbumStatusModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}