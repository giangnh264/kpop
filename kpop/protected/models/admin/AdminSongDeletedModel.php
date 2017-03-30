<?php

Yii::import('application.models.db.SongDeletedModel');

class AdminSongDeletedModel extends SongDeletedModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}