<?php

Yii::import('application.models.db.CollectionGenreModel');

class AdminCollectionGenreModel extends CollectionGenreModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}