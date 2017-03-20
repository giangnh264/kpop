<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsNews
 *
 * @author longnt2
 * Function
 *      + tinon: Dang ky nhan ban tin am nhac mien phi
 *      + tinoff: Huy dang ky nhan tin am nhac mien phi
 *      + rejectSpam: Tu choi nhan quang cao
 *      + artist_fan: Dang ky hoac huy dich vu cap nhat thong tin ve ca si
 */
class SmsNews {

    protected static $_instance = null;

    private function __clone() {
        
    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function tinon($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $smsClient = new SmsClient();
        $content = "Bạn đã đăng ký nhận MIỄN PHÍ Bản tin âm nhạc cuối tuần thành công. Dịch vụ Chacha sẽ gửi tới Quý khách bản tin âm nhạc nổi bật vào sáng thứ 7 hàng tuần. Để Hủy soạn Chacha TIN Off gửi 9234. Cam on QK";
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

    public function tinoff($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $smsClient = new SmsClient();
        $content = "Quý khách đã hủy thành công dịch vụ Bản tin am nhac cuoi tuan. Để đăng ký lại soạn Chacha TIN gửi 9234. Cảm on QK";
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

    public function rejectSpam($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $sender = Formatter::formatPhone($sender);
        $smsClient = new SmsClient();
        $content = "Qúy khách đã từ chối nhận quảng cáo thành công. Cảm ơn QK";
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);

        //Insert to group tu choi nhan tin
        $sql = "SELECT * FROM spam_sms_reject_phone WHERE phone='{$sender}'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($data)) {
            Yii::app()->db->createCommand()->insert('spam_sms_reject_phone', array(
                'phone' => $sender,
            ));
        }
    }

    public function artist_fan($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $smsClient = new SmsClient();
        $sender = Formatter::formatPhone($sender);
        $content = strtoupper($content);
        $keyword = strtoupper($keyword);
        $artistKey = str_replace($keyword, "", $content);
        $artistKey = trim(strtoupper($artistKey));
        if (strpos($artistKey, "OFF") !== false) {
            //Huy nhan tin
            $artistKey = str_replace("OFF", "", $artistKey);
            $artistKey = trim(strtoupper($artistKey));
            $sql = "SELECT * FROM artist WHERE UPPER(artist_key) LIKE '{$artistKey}%'";
            $artist = Yii::app()->db->createCommand($sql)->queryRow();
            if (empty($artist)) {
                $content = "Bạn nhắn tin sai cú pháp, xin vui lòng thử lại";
            } else {
                $sql = "DELETE FROM sms_artist_fan WHERE phone = '{$sender}' AND artist_id='{$artist['id']}' ";
                Yii::app()->db->createCommand($sql)->execute();
                $content = "Quy khach da huy nhan tin ve ca si {$artist['name']} thanh cong. Tran trong!";
            }
        } else {
            $sql = "SELECT * FROM artist WHERE UPPER(artist_key) LIKE '{$artistKey}%'";
            $artist = Yii::app()->db->createCommand($sql)->queryRow();
            if (empty($artist)) {
                $content = "Bạn nhắn tin sai cú pháp, xin vui lòng thử lại";
            } else {
                $sql = "SELECT * FROM sms_artist_fan  WHERE phone = '{$sender}' AND artist_id='{$artist['id']}'";
                $logs = Yii::app()->db->createCommand($sql)->queryAll();
                if (empty($logs)) {
                    Yii::app()->db->createCommand()->insert('sms_artist_fan', array(
                        'phone' => $sender,
                        'artist_key' => $artist['artist_key'],
                        'artist_id' => $artist['id'],
                        'created_time' => new CDbExpression("NOW()")
                    ));
                }
                $content = "Cam on quy khach da dang ki cap nhat thong tin ve ca si {$artist['name']}. Quy khach se nhan duoc cac thong tin moi nhat ve ca si {$artist['name']} ngay sau khi chung toi nhan duoc. Tran trong!";
            }
        }
        $ret = $smsClient->sentMT($service_number, $sender, "0", $content, 0, "", $sms_id, $smsc);
    }

}

?>
