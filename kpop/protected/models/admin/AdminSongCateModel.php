<?php

Yii::import('application.models.db.SongCateModel');

class AdminSongCateModel extends SongCateModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}