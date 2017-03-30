<?php

Yii::import('application.models.db.SyncAlbumModel');

class AdminSyncAlbumModel extends SyncAlbumModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}