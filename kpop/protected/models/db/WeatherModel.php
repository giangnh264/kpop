<?php

class WeatherModel extends BaseWeatherModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Weather the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}