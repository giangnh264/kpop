<?php

Yii::import('application.models.db.RadioWeatherModel');

class AdminRadioWeatherModel extends RadioWeatherModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}