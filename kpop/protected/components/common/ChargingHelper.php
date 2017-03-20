<?php
class ChargingHelper
{
	public static function doCharge($params=array())
	{
		$url = Yii::app()->params["bmConfig"]["remote_wsdl"];
		$client = new SoapClient($url, array('trace' => 1));
		$result = $client->__soapCall('charging', array("xxx"=>$params));
		$result = (array) $result;
		return $result; 
	}
}
