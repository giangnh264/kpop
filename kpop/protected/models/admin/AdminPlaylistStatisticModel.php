<?php

Yii::import('application.models.db.PlaylistStatisticModel');

class AdminPlaylistStatisticModel extends PlaylistStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}