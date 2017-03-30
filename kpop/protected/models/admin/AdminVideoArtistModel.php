<?php

Yii::import('application.models.db.VideoArtistModel');

class AdminVideoArtistModel extends VideoArtistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}