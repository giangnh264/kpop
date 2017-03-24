<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsVideo
 *
 * @author longnt2
 */
class SmsVideo {

    protected static $_instance = null;

    private function __clone() {

    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function download($code, $from_phone, $to_phone, $source, $promotion, $sms_id) {
		try {
			$bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
			$client = new SoapClient($bmUrl, array('trace' => 1));
			$params = array(
				'code' => $code,
				'from_phone' => $from_phone,
				'to_phone' => $to_phone,
				'source' => $source,
				'promotion' => $promotion,
				'smsId' => $sms_id,
			);
			$result = $client->__soapCall('downloadVideo', $params);
			return $result;
		} catch (Exception $e) {
			Yii::log($e->getMessage(), "error", "exeption.BMException");
		}
    }

}

?>
