<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsRbt
 *
 * @author longnt2
 */
class SmsRbt {

    protected static $_instance = null;

    private function __clone() {

    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function download($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        try {
            $tophone = $sender;
            $array = explode(' ', $content);
            foreach ($array as $k => $v) {
                if ($v == '')
                    unset($array[$k]);
            }
            // bien flag $give == 1 => tin nhan tang bai hat
            // bien flag $give == 2 => so dien thoai tang ko la thue bao vinaphone
            $give = 0;
            $nbto = $array[sizeof($array) - 1];
            if (count($array) > 2 && is_numeric($nbto) && SmsHelper::getInstance()->isPhone($nbto)) {
                if (Formatter::isVinaphoneNumber($nbto)) {
                    $tophone = Formatter::removePrefixPhone($nbto);
                    $give = 1;
                } elseif (!Formatter::isVinaphoneNumber($nbto)) {
                    $give = 2;
                }
            }

            // neu la tin nhan tang bai hat $give != 0 => tach lay ma hoac ten bai hat tu $content
            $tmp = $array;
            if ($give) {
                unset($tmp[sizeof($array) - 1]);
                unset($tmp[0]);
                $sing = implode(' ', $tmp);
            } else {
                unset($tmp[0]);
                $sing = implode(' ', $tmp);
            }
            $params = array(
                'code' => $sing,
                'from_phone' => Formatter::formatPhone($sender),
                'to_phone' => Formatter::formatPhone($tophone),
                'channel' => 'web',
                'promotion' => 0
            );
            $rbt = RbtModel::model()->findByAttributes(array("code" => $sing));
            $name = $rbt->name;
            // $sing: ma bai hoac ten bai hat
            if (!is_numeric($sing)) {
                $results = SmsHelper::getInstance()->searchSolr($sing, 'name', 5);
                $code = $results[0]['param'];
                $name = $results[0]['name'];
                $params = array(
                    'code' => $code,
                    'from_phone' => Formatter::formatPhone($sender),
                    'to_phone' => Formatter::formatPhone($tophone),
                    'channel' => 'web',
                    'promotion' => 0
                );
            }
            $bmWsdl = Yii::app()->params['bmConfig']['remote_wsdl'];
            $client = new SoapClient($bmWsdl, array('trace' => 1));
            $ret = $client->__soapCall("downloadRbt", $params);
            $smsClient = new SmsClient();
            if ($ret->errorCode != 0) {
                $content = "Ban gap loi trong qua trinh cai dat, vui long thu lai!";
                $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
            } else {
                $content = "Ban da cai dat nhac cho thanh cong cho thue bao {$tophone} bai hat '{$name}'.";
                $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), "error", "exeption.BMException");
        }
    }

    // Tim kiem: bai hat hot, bai bat moi, tim bai theo ca si, tim theo ten bai hat
    public function search($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        try {
            $string = '';
            $content = trim($content);
            $array = explode(' ', $content);
            foreach ($array as $k => $v) {
                if ($v == '')
                    unset($array[$k]);
            }
            //DATEDIFF(NOW(),t.created_time) <= '120' and
            if ((strtolower($array[1]) == 'hot' && count($array) == 2) || strtolower($content) == 'tk') {
                // Tim kiem bai hot
                $config = SmsConfigModel::model()->findByAttributes(array("keyword" => "tk", 'group_key' => 'ringtone', 'index_key' => 'hot'));
                if ($config->status == 1) {
                    $string = $config->content;
                } else {
                    $cr = new CDbCriteria();
                    $cr->select = "t.*, t2.downloaded_count";
                    $cr->join = "INNER JOIN rbt_statistic t2 ON t.id = t2.rbt_id";
                    $cr->condition = "t.status = '1'";
                    $cr->order = "t2.downloaded_count DESC";
                    $cr->limit = 5;
                    $cr->offset = 0;
                    $RbtNew = RbtModel::model()->findAll($cr);
                    foreach ($RbtNew as $rbt) {
                        $string .= $rbt['name'] . ": " . $rbt['code'] . ', ';
                    }
                    $string = $string != '' ? substr($string, 0, -2) . '.' : 'Khong co bai phu hop!';
                }
                $content = "Ringtone Hot: {$string}";
            } elseif (strtolower($array[1]) == 'moi' && count($array) == 2) {
                // Tim kiem bai moi
                $cr = new CDbCriteria();
                $cr->select = "t.*";
                $cr->join = "INNER JOIN rbt_ringtune t2 ON t.content_id = t2.content_id";
                $cr->condition = " t2.content_owner = 'VEGA' and t.status = '1'";
                $cr->order = "t.created_time DESC";
                $cr->limit = 5;
                $cr->offset = 0;
                $RbtNew = RbtModel::model()->findAll($cr);
                foreach ($RbtNew as $rbt) {
                    $string .= $rbt['name'] . ": " . $rbt['code'] . ', ';
                }
                $string = $string != '' ? substr($string, 0, -2) . '.' : 'Khong co bai phu hop!';
                $content = "Ringtone New: {$string}";
            } elseif (strtolower($array[1]) == 'casi' && count($array) >= 3) {
                // Tim kiem ma bai hat theo ca si.
                $name = substr(implode(' ', $array), 8);
                $cr = new CDbCriteria();
                $cr->select = "t.*, t2.downloaded_count";
                $cr->join = "INNER JOIN rbt_statistic t2 ON t.id = t2.rbt_id";
                $cr->condition = "LCASE(artist_name) = :ARTIST_NAME and t.status = '1'";
                $cr->params = array(':ARTIST_NAME' => strtolower($name));
                $cr->order = "t2.downloaded_count DESC";
                $cr->limit = 5;
                $cr->offset = 0;
                $RbtNew = RbtModel::model()->findAll($cr);
                foreach ($RbtNew as $rbt) {
                    $string .= $rbt['name'] . ":" . $rbt['code'] . ', ';
                }
                $string = $string != '' ? substr($string, 0, -2) . '.' : 'Khong co bai phu hop!';
                $content = "Ringtone cua ca si \"{$name}\": {$string}";
            } else {
                // Tim kiem theo ten bai tra ra ma bai hat
                $name = substr(implode(' ', $array), 3);
                $RbtNew = SmsHelper::getInstance()->searchSolr($name, 'name', 5);
                foreach ($RbtNew as $rbt) {
                    $string .= $rbt['name'] . ": " . $rbt['param'] . ', ';
                }
                $string = $string != '' ? substr($string, 0, -2) . '.' : 'Khong co bai phu hop!';
                $content = "Ringtone theo ten bai hat \"{$name}\": {$string}";
            }
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
        } catch (Exception $e) {
			Yii::log($e->getMessage(), "error");
        }
    }

}

?>
