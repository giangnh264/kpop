<?php

Yii::import('application.models.db.WeatherModel');

class AdminWeatherModel extends WeatherModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}