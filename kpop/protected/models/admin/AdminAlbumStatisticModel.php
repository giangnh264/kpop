<?php

Yii::import('application.models.db.AlbumStatisticModel');

class AdminAlbumStatisticModel extends AlbumStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}