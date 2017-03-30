<?php

Yii::import('application.models.db.TopPlaylistDayModel');

class AdminTopPlaylistDayModel extends TopPlaylistDayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}