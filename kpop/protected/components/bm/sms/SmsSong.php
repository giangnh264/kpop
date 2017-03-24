<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsSong
 *
 * @author longnt2
 */
class SmsSong {

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
			$result = $client->__soapCall('downloadSong', $params);
			return $result;
		} catch (Exception $e) {
			Yii::log($e->getMessage(), "error", "exeption.BMException");
		}
    }

    public function search($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $result = '';
        try {
            switch (strtoupper($keyword)) {
                case "MA":
                    $sender = Formatter::formatPhone($sender);
                    $name = trim(substr($content, 3));
                    $arrKey = array("     ", "    ", "   ", "  ");
                    $string = str_replace($arrKey, ' ', $name);

//                    $criteria = new CDbCriteria();
//                    $criteria->condition = "status = 1";
//                    $criteria->addCondition("name like '%$string%'");
//                    $criteria->limit = 5;
//                    $results = SongModel::model()->findAll($criteria);
                    
                    $response = SearchHelper::getInstance()->search($string, 'song', 5, 0);
                    $results = $this->copyAndCast($response->docs, array('name' => 'name', 'artist_name' => 'artist_name'));
                    $result = "Ban da soan sai Ten bai hat, xin vui long kiem tra lại. Tin nhan vi du: MA con duong mua. Ban co the truy cap http://quatangamnhac.chacha.vn de biet them chi tiet.";
                    if ($response->numFound > 0) {
                        $result = "Danh sach ma bai hat co ten {$string}: ";
                        foreach ($results as $song) {
                        	$checkConvert = $this->checkConvertIVR($song['id']);
                        	if($checkConvert){
	                            $name = VegaCommonFunctions::removeVietnamese($song['name']);
	                            $arrKey = array("     ", "    ", "   ", "  ", " ");
	                            $name = str_replace($arrKey, '', $name);
	                            $result .= " ({$song['code']}-{$name}-{$song['artist']})";
                        	}
                        }
                    }
                    break;
                case "HOT":
                    $config = SmsConfigModel::model()->findByAttributes(array("keyword" => "HOT"));
                    if ($config->status == 1) {
                        $result = $config->content;
                        break;
                    }
                    $songs = MainContentModel::getListByCollection('SONG_HOT', 1, 5);
                    if (count($songs) > 0) {
                        foreach ($songs as $song) {
                            $name = VegaCommonFunctions::removeVietnamese($song['name']);
                            $arrKey = array("     ", "    ", "   ", "  ", " ");
                            $name = str_replace($arrKey, '', $name);
                            $result .= "{$name}({$song['code']}), ";
                        }
                    }
                    $result = 'TOP HOT: ' . substr($result, 0, -2) . '. Soan QUATANG gui 9234 de co ma 10 bai hat duoc tang nhieu nhat';
                    break;
                case "QUATANG":
                    $config = SmsConfigModel::model()->findByAttributes(array("keyword" => "QUATANG"));
                    if ($config->status == 1) {
                        $result = $config->content;
                        break;
                    }
                    $songs = MainContentModel::getListByCollection('QUATANG_AMNHAC', 1, 5);
                    if (count($songs) > 0) {
                        foreach ($songs as $song) {
                            $name = VegaCommonFunctions::removeVietnamese($song['name']);
                            $arrKey = array("     ", "    ", "   ", "  ", " ");
                            $name = str_replace($arrKey, '', $name);
                            $result .= "{$name}({$song['code']}), ";
                        }
                    }
                    $result = 'TOP QT: ' . substr($result, 0, -2) . '. Soan HOT gui 9234 de co ma 10 bai hat moi nhat';
                    break;
                case "GT":
                    $col = trim(substr($content, 3));
                    $arrKey = array("     ", "    ", "   ", "  ", " ");
                    $key = str_replace($arrKey, '', $col);
                    $arr = array(
                        'phunu' => 'MUSICGIFT_WOMEN_DAY',
                        'sinhnhat' => 'MUSICGIFT_BIRTHDAY',
                        'banbe' => 'MUSICGIFT_FRIENDS',
                        'giadinh' => 'MUSICGIFT_FAMILY',
                        'tinhyeu' => 'MUSICGIFT_LOVE',
                        'totinh' => 'MUSICGIFT_CONFESSION',
                        'henho' => 'MUSICGIFT_DATING',
                        'hanhphuc' => 'MUSICGIFT_HAPPINESS',
                        'gianhon' => 'MUSICGIFT_ANGER',
                        'xinloi' => 'MUSICGIFT_SORRY',
                        'hoitiec' => 'MUSICGIFT_REGRETS',
                        'chucmung' => 'MUSICGIFT_CONGRATULA'
                    );
                    if ($arr[$key]) {
                        $count = MainContentModel::countListByCollection($arr[$key]);
                        $page = floor($count/5);
                        $offset = rand(1,$page);
                        $items = MainContentModel::getListByCollection($arr[$key], $offset, 5);
                        foreach ($items as $song) {
                            $name = VegaCommonFunctions::removeVietnamese($song['name']);
                            $arrKey = array("     ", "    ", "   ", "  ", " ");
                            $name = str_replace($arrKey, '', $name);
                            $result .= "{$name}({$song['code']}), ";
                        }
                        $result = "Cac bai hat duoc yeu thich trong chu de {$key}: " . substr($result, 0, -2);
                    } else {
                        $result = "Ban da soan sai Ten chu de, xin vui long kiem tra lai. Tin nhan vi du: GT sinhnhat. Ban co the truy cap http://quatangamnhac.chacha.vn de biet them chi tiet.";
                    }
                    break;
            }
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
        } catch (Exception $e) {

        }
    }

    public function down9234($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $sender = Formatter::formatPhone($sender);
        $code = trim(substr($content, 4));
        $result = "Ma bai hat cua ban khong dung. Xin moi ban kiem tra lai.Ban co the goi dien toi tong dai 9234 hoac truy cap http://quatangamnhac.chacha.vn de duoc huong dan.";
        $song = SongModel::model()->findByAttributes(array("code" => $code));
        if ($song && $code && is_numeric($code)) {
            $link = SongModel::model()->getAudioFileUrl($song['id'], '', 'rtsp', $song['profile_ids']);
            $result = "QK vui long bam vao link ben duoi de download bai hat {$song['name']}: {$link} .Cam on ban da su dung dich vụ!";
        }
        $smsClient = new SmsClient();
        $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
    }

    public function gift($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $content = trim(substr($content, 5));
        $arrKey = array("     ", "    ", "   ", "  ");
        $string = str_replace($arrKey, ' ', $content);
        $array = explode(' ', $string);
        $code = $array[0];
        $code = str_replace("S", "", $code);

        $tophone = Formatter::formatPhone($array[1]);
//        $song = SongModel::model()->findByAttributes(array("code" => $code));
        $cr = new CDbCriteria();
        $cr->select = "t.*, t2.ivr_convert_status";
        $cr->join = "INNER JOIN song_status t2 ON t.id = t2.song_id";
        $cr->condition = "t.status = 1 AND t2.ivr_convert_status = '1' and t.code = '{$code}'";
        $cr->limit = 1;
        $song = SongModel::model()->find($cr);

        if (!$song) {
            $result = 'Ban da soan sai ma so bai hat, xin vui long kiem tra lai tin nhan; hoac truy cap http://quatangamnhac.chacha.vn de tra cuu chi tiet.';
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
            return;
        }
        if (!Formatter::isVinaphoneNumber($tophone)) {
            $result = 'Quy khach nhap sai so dien thoai nguoi nhan. So dien thoai nguoi nhan phai la thue bao VinaPhone. Quy khach vui long kiem tra va thu lai';
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
            return;
        }
        if (sizeof($array) == 2) {
			try {
	            $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
	            $client = new SoapClient($bmUrl, array('trace' => 1));
	            $params = array(
	                "code" => $song['code'],
	                "from_phone" => $sender,
	                "to_phone" => $tophone,
	                "record_filePath" => '',
	                "send_now" => 1, //integer
	                "delivery_time" => date('Y-m-d H:i:s'),
	                "source_type" => 'sms',
	                "smsId" => NULL
	            );

                $res = $client->__soapCall('giftSong', $params);
                $kloger = new KLogger('log_giftsong_error', KLogger::INFO);
                $kloger->LogInfo("from:$sender|to:$tophone|return:".json_encode($res),false);
            } catch (Exception $e) {
				Yii::log($e->getMessage(), "error", "exeption.BMException");
            }
            return;
        }
        if (sizeof($array) == 4) {
            $date = $array[2];
            $day = substr($date, 0, 2);
            $month = substr($date, 2);
            $time = strtotime($month . '/' . $day . '/' . date('Y'));
            if (!$time || strlen($date) != 4 || $time < strtotime(date("Y-m-d 00:00:00"))) {
                $result = "Ban da soan sai ngay thang tang qua, xin hay nhap du 4 chu so nhu vi du: 2603 (26 thang 3). Truy cap http://quatangamnhac.chacha.vn tra cuu them.";
                $smsClient = new SmsClient();
                $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
                return;
            }
            $hour = $array[3];
            if (!is_numeric($hour) || substr($hour, 2) > 59 || substr($hour, 2) < 0 || substr($hour, 0, 2) > 23 || substr($hour, 0, 2) < 0) {
                $result = "Ban da soan sai thoi gian tang qua, xin hay nhap du 4 chu so nhu vi du: 2230 (22 gio 30 phut).Truy cap http://quatangamnhac.chacha.vn tra cuu them.";
                $smsClient = new SmsClient();
                $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
                return;
            }
            if (strlen($hour) != 4) {
                $result = "Tin nhan sai cu phap, vui long nhap thoi gian theo dinh dang NNTT GGPP. Goi 18001091(200d/p) hoac truy cap website http://quatangamnhac.chacha.vn de duoc HD";
                $smsClient = new SmsClient();
                $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
                return;
            }
            if (date('Y-' . $month . '-' . $day . ' ' . substr($hour, 0, 2) . ':' . substr($hour, 2) . ':00') < date('Y-m-d H:i:s')) {
                $result = "Thoi gian tang qua phai lon hon hien tai. Goi 18001091(200d/p) hoac truy cap website http://quatangamnhac.chacha.vn de duoc HD";
                $smsClient = new SmsClient();
                $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
                return;
            }
			try {
				$bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
				$client = new SoapClient($bmUrl, array('trace' => 1));
				$time_send = date('Y-' . $month . '-' . $day . ' ' . substr($hour, 0, 2) . ':' . substr($hour, 2) . ':00');
				$params = array(
					"code" => $song['code'],
					"from_phone" => $sender,
					"to_phone" => $tophone,
					"record_filePath" => '',
					"send_now" => 0, //integer
					"delivery_time" => $time_send,
					"source_type" => 'sms',
					"smsId" => NULL
				);

                $res = $client->__soapCall('giftSong', $params);
                $kloger = new KLogger('log_giftsong_error', KLogger::INFO);
                $kloger->LogInfo("from:$sender|to:$tophone|return:".json_encode($res),false);
            } catch (Exception $e) {
				Yii::log($e->getMessage(), "error", "exeption.BMException");
            }
            return;
        }

        $result = "Tin nhan sai cu phap. Goi 18001091(200d/p) hoac truy cap website http://quatangamnhac.chacha.vn de duoc HD";
        $smsClient = new SmsClient();
        $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
    }

    public function help($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $result = Yii::app()->params['sms_help'];
//        $result = "De nghe nhac xem tai bai hat, MV dac sac DOC QUYEN tai Amusic va mien cuoc 3G khi su dung, soan DK Tengoi gui 9166 (Tengoi: A1 – 2000d/ngay, A7 – 7000d/tuan). De kiem tra goi cuoc soan KT gui 9166. De biet gia cuoc soan GIA gui 9166. De huy soan HUY Tengoi gui 9166 hoac truy cap http://amusic.vn de biet them chi tiet. Chi tiet goi 9090 (200d/phut). Tran trong cam on!";
        $smsClient = new SmsClient();
        $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
    }

    public function firtsday($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $start = date('Y-m-d 00:00:00');
        $cr = new CDbCriteria();
        $cr->select = "t.*, t2.downloaded_count";
        $cr->join = "INNER JOIN song_statistic t2 ON t.id = t2.song_id";
        $cr->condition = "t.user_phone = '{$sender}' and t.created_time < NOW() and t.created_time > '{$start}'";
        $isfirst = UserTransactionModel::model()->findAll($cr);
        if (!$isfirst) {
            $cr = new CDbCriteria();
            $cr->select = "t.*, t2.downloaded_count";
            $cr->join = "INNER JOIN song_statistic t2 ON t.id = t2.song_id";
            $cr->condition = "t.status = '1'";
            $cr->order = "t2.downloaded_count DESC";
            $cr->limit = 5;
            $cr->offset = 0;
            $song = SongModel::model()->findAll($cr);
            $result = "TOP QT ";
            if (count($song) > 0) {
                foreach ($song as $s) {
                    $result .= "{$s['name']}: {$s['code']}, ";
                }
            }
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
        }
    }

    private function copyAndCast($array, $mapping) {
        $rs = array();
        foreach ($array as $item) {
            $cast = array();
            foreach ($item as $key => $value) {
                if ($key == 'id') {
                    $cast['id'] = substr($value, strlen($item->type));
                } elseif (array_key_exists($key, $mapping)) {
                    $key = $mapping[$key];
                    if (is_array($key)) {
                        $value = explode('|', $value);
                        for ($index = 0; $index < count($key);) {
                            $key2 = $key[$index++];
                            $cast[$key2] = $value[$key[$index++]];
                        }
                    }else
                        $cast[$key] = $value;
                }else
                    $cast[$key] = $value;
            }
            $rs[] = $cast;
        }
        return $rs;
    }
	private function checkConvertIVR($songId)
	{
		if($songId>0){
			$sql = "SELECT ivr_convert_status FROM song_status where song_id=$songId";
			$result = Yii::app()->db->createCommand($sql);
			if($result){
				$status = $result->queryScalar();
				if($status>0){
					return true;
				}
			}
		}
		return false;
	}
}

?>
