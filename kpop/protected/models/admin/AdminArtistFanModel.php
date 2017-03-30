<?php

Yii::import('application.models.db.ArtistFanModel');

class AdminArtistFanModel extends ArtistFanModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}