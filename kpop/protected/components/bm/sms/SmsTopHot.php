<?php
Yii::import("application.modules.contest.models.db.*");
Yii::import("application.modules.contest.models.db._base.*");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsTopHot
 *
 * @author Haltn
 */
class SmsTopHot {

    protected static $_instance = null;

    private function __clone() {

    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }



    public function vote($service_number, $sender, $content, $keyword, $sms_id, $smsc) {
        $content = trim(substr($content, 3));
        $arrKey = array("     ", "    ", "   ", "  ");
        $string = str_replace($arrKey, ' ', $content);
        $array = explode(' ', $string);
        $code = $array[0];
        //$vote = Formatter::formatPhone($array[1]);
        $vote = (int) $array[1];
        $sender = Formatter::formatPhone($sender);

        $sql = "SELECT t.id, t.status, t.code, content.contest_id as contest_id, content.topic_id as topic_id
        		FROM song t
        		INNER JOIN contest_content as content ON t.id = content.content_id INNER JOIN contest as contest ON content.contest_id = contest.id INNER JOIN contest_topic as topic ON content.topic_id = topic.id
        		WHERE t.status = 1  and content.content_code = '{$code}' and contest.status = 1 and topic.status=1
        		LIMIT 1";
        $song = Yii::app()->db->createCommand($sql)->queryAll();
        /*
        $cr = new CDbCriteria();
		$cr->select = "t.id, t.status, t.code, content.contest_id as contest_id, content.topic_id as topic_id ";
        $cr->join = "INNER JOIN contest_content as content ON t.id = content.content_id INNER JOIN contest as contest ON content.contest_id = contest.id INNER JOIN contest_topic as topic ON content.topic_id = topic.id";
        $cr->condition = "t.status = 1  and t.code = '{$code}' and contest.status = 1 and topic.status=1";

        $cr->limit = 1;

        $song = SongModel::model()->find($cr);
 		*/

        if (!$song) {
            $result = 'Ban da soan sai ma so bai hat, xin vui long kiem tra lai tin nhan; hoac truy cap http://chacha.vn/ de tra cuu chi tiet.';
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
            return;
        }
       /*  if (!is_numeric($vote)) {
            $result = 'Ban da soan sai so nguoi cung bau chon, xin vui long kiem tra lai tin nhan.';
            $smsClient = new SmsClient();
            $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
            return;
        } */

        try {
        	$contentId = $song[0]['id'];
        	$sql = "SELECT COUNT(*) AS total FROM contest_activity WHERE content_id = '{$contentId}' AND msisdn='{$sender}' AND action='BC' AND date(created_time)=date(NOW())";
        	$data = Yii::app()->db->createCommand($sql)->queryRow();
        	$count = empty( $data)?0:$data['total'];
			if($count<5){
				$activity = new ContestActivityModel();
				$activity->setAttribute('created_time', date("Y-m-d H:i:s"));
				$activity->setAttribute('msisdn', $sender);
				$activity->setAttribute('content_id', $song[0]['id']);
				$activity->setAttribute('contest_id', $song[0]['contest_id']);
				$activity->setAttribute('topic_id', $song[0]['topic_id']);
				$activity->setAttribute('action', 'BC');
				$activity->setAttribute('first_params', $vote);
				$ret = $activity->save();
				if(!$ret){
					echo "<pre>";print_r($activity->getErrors());exit();
				}
			}

        	$result = "Chacha.vn da ghi nhan ket qua binh chon cua ban. Cam on ban da tham gia binh chon Bai hat thang cua Chacha Top HOT. Chi tiet truy cap http://chacha.vn";
        	$smsClient = new SmsClient();
        	$smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
            return;
        } catch (Exception $e) {

        }

        $result = "Tin nhan sai cu phap. Goi 18001091(200d/p) hoac truy cap website http://chacha.vn/ de duoc HD";
        $smsClient = new SmsClient();
        $smsClient->sentMT($service_number, $sender, "0", $result, 0, "", $sms_id, $smsc);
    }
}

?>
