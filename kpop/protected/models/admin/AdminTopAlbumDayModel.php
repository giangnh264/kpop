<?php

Yii::import('application.models.db.TopAlbumDayModel');

class AdminTopAlbumDayModel extends TopAlbumDayModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}