<?php

Yii::import('application.models.db.LogMsisdnCampaignModel');

class AdminLogMsisdnCampaignModel extends LogMsisdnCampaignModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}