<?php

Yii::import('application.models.db.MgChannelModel');

class AdminMgChannelModel extends MgChannelModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}