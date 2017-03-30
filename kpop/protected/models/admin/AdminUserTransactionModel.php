<?php

Yii::import('application.models.db.UserTransactionModel');

class AdminUserTransactionModel extends UserTransactionModel {

    var $className = __CLASS__;
	protected $_dkhuy=false;
	protected $_content=false;
    protected $_extend=false;
    protected $_revenue=false;
    protected $_use=false;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * Số giao dịch trong ngày
     * */

    public function getTotalTransByTime($action = 'play_song', $time = null) {
        if (!$time)
            $time = date("Y-m-d");
        //$fromTime = $time." 00:00:00";
        //$toTime = $time." 23:59:59";

        if (is_array($time)) {
            $fromTime = $time['from'] . " 00:00:00";
            $toTime = $time['to'] . " 23:59:59";
        } else {
            $fromTime = $time . " 00:00:00";
            $toTime = $time . " 23:59:59";
        }


        //Tổng số transaction trong ngày
       /*  if($action == "subscribe") $count = "COUNT(distinct user_phone)";
        else $count = "COUNT(*)"; */
        $count = "COUNT(distinct user_phone)";
        $sql = "SELECT
					$count AS total, channel
				FROM
					user_transaction
				WHERE
					transaction = '{$action}' AND created_time >= '{$fromTime}' AND created_time <= '{$toTime}' AND return_code = '0'
				GROUP BY channel
				";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if (!empty($data))
            return $data;
        return array();
    }

    /*
     * Số Giao dịch Free
     * */

    public function getTotalTransFreeByTime($action = 'play_song', $time = null) {
        if (!$time)
            $time = date("Y-m-d");
        //$fromTime = $time." 00:00:00";
        //$toTime = $time." 23:59:59";

        if (is_array($time)) {
            $fromTime = $time['from'] . " 00:00:00";
            $toTime = $time['to'] . " 23:59:59";
        } else {
            $fromTime = $time . " 00:00:00";
            $toTime = $time . " 23:59:59";
        }

        $sql = "
    		SELECT
    			COUNT(*) AS total, channel
    		FROM
    			user_transaction
    		WHERE
    			transaction = '{$action}' AND created_time >= '{$fromTime}' AND created_time <= '{$toTime}' AND return_code = '0' AND price = 0
    		GROUP BY channel
    	";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if (!empty($data))
            return $data;
        return array();
    }

    /*
     * Tổng doanh thu trong ngày
     * */

    public function getTotalRevByTime($action = null, $time = null) {
        if (!$time)
            $time = date("Y-m-d");
        //$fromTime = $time." 00:00:00";
        //$toTime = $time." 23:59:59";

        if (is_array($time)) {
            $fromTime = $time['from'] . " 00:00:00";
            $toTime = $time['to'] . " 23:59:59";
        } else {
            $fromTime = $time . " 00:00:00";
            $toTime = $time . " 23:59:59";
        }

        //Doanh số transaction trong ngày
        $where = "1=1 ";
        if ($action) {
            $where .= " AND transaction = '{$action}'";
        } else {
            $where .= " AND transaction <> 'download_rbt' AND transaction <> ''";
        }
        $sql = "SELECT
					SUM(price) AS total
				FROM
					user_transaction
				WHERE
				$where AND created_time >= '{$fromTime}' AND created_time <= '{$toTime}' AND return_code = '0'
					 AND ( NOT (transaction = 'play_album' AND obj2_id <> 0)) AND transaction NOT IN ('gift_song','download_rbt')
				";

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        if (!empty($data))
            return $data['total'];
        return 0;
    }

    public function getAllByTime($time) {
        if (!$time)
            $time = date("Y-m-d");

        if (is_array($time)) {
            $fromTime = $time['from'] . " 00:00:00";
            $toTime = $time['to'] . " 23:59:59";
        } else {
            $fromTime = $time . " 00:00:00";
            $toTime = $time . " 23:59:59";
        }

        $sql = "
		SELECT
			date(created_time) as m,
			SUM(CASE WHEN transaction ='play_song' THEN 1 ELSE 0 END) AS total_playsong,
			SUM(CASE WHEN transaction ='play_song' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_playsong,
			SUM(CASE WHEN transaction ='play_song' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_playsong,
			SUM(CASE WHEN transaction ='play_song' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_playsong,

			SUM(CASE WHEN transaction ='download_song' THEN 1 ELSE 0 END) AS total_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='web' THEN 1 ELSE 0 END) AS total_web_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='sms' THEN 1 ELSE 0 END) AS total_sms_downloadsong,
			SUM(CASE WHEN transaction ='download_song' AND channel='chachastar' THEN 1 ELSE 0 END) AS total_chachastar_downloadsong,

			SUM(CASE WHEN transaction ='play_video' THEN 1 ELSE 0 END) AS total_playvideo,
			SUM(CASE WHEN transaction ='play_video' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_playvideo,
			SUM(CASE WHEN transaction ='play_video' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_playvideo,
			SUM(CASE WHEN transaction ='play_video' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_playvideo,

			SUM(CASE WHEN transaction ='download_video' THEN 1 ELSE 0 END) AS total_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='web' THEN 1 ELSE 0 END) AS total_web_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='sms' THEN 1 ELSE 0 END) AS total_sms_downloadvideo,
			SUM(CASE WHEN transaction ='download_video' AND channel='chachastar' THEN 1 ELSE 0 END) AS total_chachastar_downloadvideo,

			SUM(CASE WHEN transaction ='subscribe' THEN 1 ELSE 0 END) AS total_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='web' THEN 1 ELSE 0 END) AS total_web_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='sms' THEN 1 ELSE 0 END) AS total_sms_subscribe,
			SUM(CASE WHEN transaction ='subscribe' AND channel='admin' THEN 1 ELSE 0 END) AS total_admin_subscribe,
                        SUM(CASE WHEN transaction ='subscribe' AND channel='ivr' THEN 1 ELSE 0 END) AS total_ivr_subscribe,
                        SUM(CASE WHEN transaction ='subscribe' AND channel='vinaphone' THEN 1 ELSE 0 END) AS total_vinaphone_subscribe,

			SUM(CASE WHEN transaction ='subscribe' AND price=0 THEN 1 ELSE 0 END) AS total_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='wap' AND price=0 THEN 1 ELSE 0 END) AS total_wap_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='api-ios' AND price=0 THEN 1 ELSE 0 END) AS total_ios_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='api-android' AND price=0 THEN 1 ELSE 0 END) AS total_android_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='web' AND price=0 THEN 1 ELSE 0 END) AS total_web_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='sms' AND price=0 THEN 1 ELSE 0 END) AS total_sms_subscribe_free,
			SUM(CASE WHEN transaction ='subscribe' AND channel='admin' AND price=0 THEN 1 ELSE 0 END) AS total_admin_subscribe_free,
                        SUM(CASE WHEN transaction ='subscribe' AND channel='ivr' AND price=0 THEN 1 ELSE 0 END) AS total_ivr_subscribe_free,
                        SUM(CASE WHEN transaction ='subscribe' AND channel='vinaphone' AND price=0 THEN 1 ELSE 0 END) AS total_vinaphone_subscribe_free,

			SUM(CASE WHEN transaction ='subscribe_ext' THEN 1 ELSE 0 END) AS total_subscribe_ext,

			SUM(CASE WHEN transaction ='unsubscribe' THEN 1 ELSE 0 END) AS total_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='wap' THEN 1 ELSE 0 END) AS total_wap_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='api-ios' THEN 1 ELSE 0 END) AS total_ios_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='api-android' THEN 1 ELSE 0 END) AS total_android_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='web' THEN 1 ELSE 0 END) AS total_web_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='sms' THEN 1 ELSE 0 END) AS total_sms_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='auto' THEN 1 ELSE 0 END) AS total_auto_unsubscribe,
			SUM(CASE WHEN transaction ='unsubscribe' AND channel='admin' THEN 1 ELSE 0 END) AS total_admin_unsubscribe,
                        SUM(CASE WHEN transaction ='unsubscribe' AND channel='vinaphone' THEN 1 ELSE 0 END) AS total_vinaphone_unsubscribe
		 FROM user_transaction
		 WHERE created_time >= '{$fromTime}' AND created_time <= '{$toTime}' AND return_code = '0'
		 GROUP BY m
		 ORDER BY m DESC
    	";

        return $data = Yii::app()->db->createCommand($sql)->queryAll();
    }


    public function getTotalRevByCP($cpId, $time, $packageId = 3) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $where = " AND (created_time >='{$from}' AND created_time <='{$to}')";
        $cpName = AdminCpModel::model()->findByPk($cpId)->name;
        if($packageId == 3){
            $where_package = " AND true ";
        }else{
            $where_package = " AND package_id={$packageId}";
        }
        $sql = "SELECT
    				date AS m,
					SUM(total_play) AS total_streaming,
					SUM(play_cp) AS streaming_cp,
					SUM(total_download) AS total_download,
					SUM(download_cp) AS download_cp
				FROM statistic_revenue_cp
				WHERE cp_id='$cpId' and (date between '{$from}' and '{$to}') $where_package
				GROUP BY m
				ORDER BY m DESC
				";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = "
    			SELECT
    				date AS m, SUM(revenue_msisdn) AS total_revenue
    			FROM
    				statistic_revenue_cp
				WHERE
					(date between '{$from}' and '{$to}') $where_package
				GROUP BY m";
        $totalRevPackage = Yii::app()->db->createCommand($sql)->queryAll();
        $revPackage = array();
        foreach ($totalRevPackage as $rev) {
            $revPackage[$rev['m']] = $rev['total_revenue'];
        }
        //echo "<pre>";print_r($revPackage);exit();
        return array('cpTrans' => $data, 'revPackage' => $revPackage);
    }

    public function getTotalRevContentByCP($cpId, $time, $genreList = array()) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $where = " AND (created_time >'{$from}' AND created_time <'{$to}')";

        #echo "<pre>";print_r($genreList);exit();

        $genreSongVi = implode(",", $genreList['song']['vi']);
        $genreSongQt = implode(",", $genreList['song']['qt']);
        $genreVideoVi = implode(",", $genreList['video']['vi']);
        $genreVideoQt = implode(",", $genreList['video']['qt']);
        $genreRingtoneVi = implode(",", $genreList['rt']['vi']);
        $genreRingtoneQt = implode(",", $genreList['rt']['qt']);


        // Tu thang 7 tinh thong ke trong bang log_cdr
        $tableName = 'user_transaction';
        $conditionReturn = " AND return_code=0";
        if($from >= '2013-07-01 00:00:00'){
        	$tableName = 'log_cdr';
        	$conditionReturn = '';
        }

        /* $sql = "SELECT date(created_time) AS date,
                    SUM(CASE WHEN (transaction ='play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN({$genreSongVi}) THEN 1 ELSE 0 END) AS total_play_song_vi,
                    SUM(CASE WHEN transaction ='download_song' AND genre_id IN({$genreSongVi}) THEN 1 ELSE 0 END) AS total_down_song_vi,
                    SUM(CASE WHEN (transaction ='play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN({$genreSongQt}) THEN 1 ELSE 0 END) AS total_play_song_qt,
                    SUM(CASE WHEN transaction ='download_song' AND genre_id IN({$genreSongQt}) THEN 1 ELSE 0 END) AS total_down_song_qt,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoVi}) THEN 1 ELSE 0 END ) AS total_play_video_vi,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoVi}) THEN 1 ELSE 0 END ) AS total_down_video_vi,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoQt}) THEN 1 ELSE 0 END ) AS total_play_video_qt,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoQt}) THEN 1 ELSE 0 END ) AS total_down_video_qt,
                    SUM(CASE WHEN transaction ='download_ringtone' AND genre_id IN ({$genreRingtoneVi}) THEN 1 ELSE 0 END) AS total_trans_rt_vi,
                    SUM(CASE WHEN transaction ='download_ringtone' AND genre_id IN ({$genreRingtoneQt}) THEN 1 ELSE 0 END) AS total_trans_rt_qt,
                    SUM(CASE WHEN (transaction = 'play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN ({$genreSongVi}) THEN price ELSE 0 END) AS total_rev_play_song_vi,
                    SUM(CASE WHEN transaction = 'download_song' AND genre_id IN ({$genreSongVi}) THEN price ELSE 0 END) AS total_rev_down_song_vi,
                    SUM(CASE WHEN (transaction = 'play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN ({$genreSongQt}) THEN price ELSE 0 END) AS total_rev_play_song_qt,
                    SUM(CASE WHEN transaction = 'download_song' AND genre_id IN ({$genreSongQt}) THEN price ELSE 0 END) AS total_rev_down_song_qt,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoVi}) THEN price ELSE 0 END) AS total_rev_play_video_vi,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoVi}) THEN price ELSE 0 END) AS total_rev_down_video_vi,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoQt}) THEN price ELSE 0 END) AS total_rev_play_video_qt,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoQt}) THEN price ELSE 0 END) AS total_rev_down_video_qt,
                    SUM(CASE WHEN transaction ='download_ringtone' AND genre_id IN ({$genreRingtoneVi}) THEN price ELSE 0 END) AS total_rev_rt_vi,
                    SUM(CASE WHEN transaction ='download_ringtone' AND genre_id IN ({$genreRingtoneQt}) THEN price ELSE 0 END) AS total_rev_rt_qt,
                    SUM(CASE WHEN transaction ='gift_song' AND genre_id IN ({$genreSongVi}) AND created_time<='2013-10-08 16:19:21' THEN 1 ELSE 0 END) AS total_gift_song_vi,
                    SUM(CASE WHEN transaction ='gift_song' AND genre_id IN ({$genreSongVi}) AND created_time<='2013-10-08 16:19:21' THEN price ELSE 0 END) AS total_rev_gift_song_vi,
                    SUM(CASE WHEN transaction ='gift_song' AND genre_id IN ({$genreSongQt}) AND created_time<='2013-10-08 16:19:21' THEN 1 ELSE 0 END) AS total_gift_song_qt,
                    SUM(CASE WHEN transaction ='gift_song' AND genre_id IN ({$genreSongQt}) AND created_time<='2013-10-08 16:19:21' THEN price ELSE 0 END) AS total_rev_gift_song_qt
                FROM $tableName
                WHERE TRUE
                	$conditionReturn AND package_id=0 AND price>0 AND (cp_id = '{$cpId}') $where
                GROUP BY date
                ORDER BY date DESC
                "; */
        $sql = "SELECT date(created_time) AS date,
                    SUM(CASE WHEN (transaction ='play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN({$genreSongVi}) THEN 1 ELSE 0 END) AS total_play_song_vi,
                    SUM(CASE WHEN transaction ='download_song' AND genre_id IN({$genreSongVi}) THEN 1 ELSE 0 END) AS total_down_song_vi,
                    SUM(CASE WHEN (transaction ='play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN({$genreSongQt}) THEN 1 ELSE 0 END) AS total_play_song_qt,
                    SUM(CASE WHEN transaction ='download_song' AND genre_id IN({$genreSongQt}) THEN 1 ELSE 0 END) AS total_down_song_qt,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoVi}) THEN 1 ELSE 0 END ) AS total_play_video_vi,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoVi}) THEN 1 ELSE 0 END ) AS total_down_video_vi,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoQt}) THEN 1 ELSE 0 END ) AS total_play_video_qt,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoQt}) THEN 1 ELSE 0 END ) AS total_down_video_qt,
                    SUM(CASE WHEN (transaction = 'play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN ({$genreSongVi}) THEN price ELSE 0 END) AS total_rev_play_song_vi,
                    SUM(CASE WHEN transaction = 'download_song' AND genre_id IN ({$genreSongVi}) THEN price ELSE 0 END) AS total_rev_down_song_vi,
                    SUM(CASE WHEN (transaction = 'play_song' OR (transaction ='play_album' AND obj2_id <> 0)) AND genre_id IN ({$genreSongQt}) THEN price ELSE 0 END) AS total_rev_play_song_qt,
                    SUM(CASE WHEN transaction = 'download_song' AND genre_id IN ({$genreSongQt}) THEN price ELSE 0 END) AS total_rev_down_song_qt,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoVi}) THEN price ELSE 0 END) AS total_rev_play_video_vi,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoVi}) THEN price ELSE 0 END) AS total_rev_down_video_vi,
                    SUM(CASE WHEN transaction = 'play_video' AND genre_id IN ({$genreVideoQt}) THEN price ELSE 0 END) AS total_rev_play_video_qt,
                    SUM(CASE WHEN transaction = 'download_video' AND genre_id IN ({$genreVideoQt}) THEN price ELSE 0 END) AS total_rev_down_video_qt
                FROM $tableName
                WHERE TRUE
                	$conditionReturn AND package_id=0 AND price>0 AND (cp_id = '{$cpId}') $where
                GROUP BY date
                ORDER BY date DESC
                ";

        //echo $sql;exit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function registerReport($time, $return = 0, $channel = '') {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $channel = empty($channel)?"all":$channel;
        $where = "";
        $where .= " AND channel = '{$channel}'";

		$sql = "SELECT date AS m, total_register as total, total_msisdn_register as total_phone, total_msisdn_register_success as total_success
				FROM statistic_transaction
				WHERE (date BETWEEN '{$from}' AND '{$to}') $where
				GROUP BY m ORDER BY m DESC
				";
        //echo $sql;exit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function extendsReport($time, $return = 0) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $where = "";
        $where .= " AND channel = 'all'";


        $sql = "
    			SELECT
    				date AS m,
    				total_msisdn_extend_success AS total_success,
    				total_msisdn_extend AS total_phone
    			FROM statistic_transaction
    			WHERE (date BETWEEN '{$from}' AND '{$to}') $where
    			GROUP BY m
    			ORDER BY m DESC
    			 ";
        //echo $sql;exit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function unsubReport($time, $channel = '') {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $channel = empty($channel)?"all":$channel;
        $where = "";
        $where .= " AND channel = '{$channel}'";


        $sql = "
    			SELECT date AS m, total_msisdn_unregister_success AS total
    			FROM statistic_transaction
    			WHERE (date BETWEEN '{$from}' AND '{$to}') $where
    			GROUP BY m
    			ORDER BY m DESC
    			 ";
        //echo $sql;exit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function totalTransByPhone($time, $userPhone = null) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }

        $where = "";
        if ($userPhone) {
            $where .=" AND user_phone='{$userPhone}'";
        }
        $where .= " AND (created_time BETWEEN '{$from}' AND '{$to}') ";
        $where .= " AND return_code = '0'";

        $sql = "
    		SELECT
				COUNT(DISTINCT user_phone) AS total
			FROM `user_transaction` `t`
			WHERE (( NOT (transaction = 'play_album' AND obj2_id <> 0) ) AND (user_phone <> '')) $where
			";
        $total = Yii::app()->db->createCommand($sql)->queryRow();
        return $total['total'];
    }

    public function detailByPhone($time, $userPhone = null, $limit = 30, $offset = 0, $order='', $fieldOrder='') {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }

        $where = "";
        if ($userPhone) {
            $where .=" AND user_phone='{$userPhone}'";
        }
        $where .= " AND (created_time BETWEEN '{$from}' AND '{$to}') ";
        $where .= " AND return_code = '0'";
		$order = $order<>''?$order:"DESC";
		$fieldOrder = $fieldOrder<>''?$fieldOrder:"total_trans";
        $sql = "
    		SELECT
				user_phone,
				SUM(CASE WHEN transaction ='play_song' THEN 1 ELSE 0 END) AS total_playsong,
				SUM(CASE WHEN transaction ='play_song' AND price=0 THEN 1 ELSE 0 END) AS total_playsong_free,
				SUM(CASE WHEN transaction ='play_song' AND price<>0 THEN 1 ELSE 0 END) AS total_playsong_price,
				SUM(CASE WHEN transaction ='download_song' THEN 1 ELSE 0 END) AS total_downloadsong,
				SUM(CASE WHEN transaction ='download_song' AND price=0 THEN 1 ELSE 0 END) AS total_downloadsong_free,
				SUM(CASE WHEN transaction ='download_song' AND price <> 0 THEN 1 ELSE 0 END) AS total_downloadsong_price,
				SUM(CASE WHEN transaction ='play_video' THEN 1 ELSE 0 END) AS total_playvideo,
				SUM(CASE WHEN transaction ='play_video' AND price=0 THEN 1 ELSE 0 END) AS total_playvideo_free,
				SUM(CASE WHEN transaction ='play_video' AND price <> 0 THEN 1 ELSE 0 END) AS total_playvideo_price,
				SUM(CASE WHEN transaction ='download_video' THEN 1 ELSE 0 END) AS total_downloadvideo,
				SUM(CASE WHEN transaction ='download_video' AND price=0 THEN 1 ELSE 0 END) AS total_downloadvideo_free,
				SUM(CASE WHEN transaction ='download_video' AND price <> 0 THEN 1 ELSE 0 END) AS total_downloadvideo_price,
				SUM(CASE WHEN transaction IN('play_song','download_song','play_video','download_video') THEN 1 ELSE 0 END) AS total_trans

			FROM `user_transaction` `t`
			WHERE (( NOT (transaction = 'play_album' AND obj2_id <> 0) ) AND (user_phone <> '')) $where
			GROUP BY user_phone
			ORDER BY $fieldOrder $order
			LIMIT $limit
			OFFSET $offset
    	";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function detailByTransTime($time, $channel = null) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }

        $where = "";
        $where .= " AND channel = '{$channel}'";

       $sql = "
    		SELECT
				date AS m,

				SUM(total_playsong) AS total_playsong,
				SUM(total_playsong_free) AS total_playsong_free,
				SUM(total_playsong_price) AS total_playsong_price,
				SUM(total_downloadsong) AS total_downloadsong,
				SUM(total_downloadsong_free) AS total_downloadsong_free,
				SUM(total_downloadsong_price) AS total_downloadsong_price,
				SUM(total_playvideo) AS total_playvideo,
				SUM(total_playvideo_free) AS total_playvideo_free,
				SUM(total_playvideo_price) AS total_playvideo_price,
				SUM(total_downloadvideo) AS total_downloadvideo,
				SUM(total_downloadvideo_free) AS total_downloadvideo_free,
				SUM(total_downloadvideo_price) AS total_downloadvideo_price
			FROM statistic_transaction
			WHERE (date BETWEEN '{$from}' AND '{$to}') $where
			GROUP BY m
			ORDER BY m DESC
    	";
        $trans = Yii::app()->db->createCommand($sql)->queryAll();

        $return = array();
        if ($channel!='WIFI'){
	        $f = date("Y-m-d", strtotime($from));
	        $t = date("Y-m-d", strtotime($to));
	        $sql = "SELECT * FROM daily_reports WHERE report_date >= '{$f}' AND report_date <= '{$t}'";
	        $data = Yii::app()->db->createCommand($sql)->queryAll();
	        foreach ($data as $data) {
	            $return[$data['report_date']][$data['field_name']] = $data['field_value'];
	        }
        }
        return array('trans' => $trans, 'msisdn' => $return);
    }

    public function search($limit=30) {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('user_phone', $this->user_phone, false);
        if($this->_revenue){
            $criteria->addCondition("price > 0");
        }else{
            $criteria->compare('price', $this->price);
        }
        if ($this->transaction) {
            $criteria->addCondition("transaction = '{$this->transaction}'");
        }
        if($this->_dkhuy){
        	$criteria->addCondition("transaction IN ('subscribe','unsubscribe')");
        }
        if($this->_content){
        	$criteria->addCondition("(transaction in ('play_song','download_song','play_video','download_video') OR (`transaction`='play_album' and obj2_id=0))");
        }
        if($this->_use){
            $criteria->addCondition("(transaction in ('play_song','download_song','play_video','download_video') OR (`transaction`='play_album' and obj2_id=0))");
            $criteria->join = 'LEFT JOIN user_subscribe ON user_subscribe.user_phone = t.user_phone';
            $criteria->addCondition('user_subscribe.status = 1');

        }
        if($this->_extend){
        	$criteria->addCondition("(transaction in ('extend_subscribe','extend_subscribe_level1','extend_remain'))");
        }


//        $criteria->compare('transaction', $this->transaction, true);
        $criteria->compare('channel', $this->channel, true);
        $criteria->compare('obj1_id', $this->obj1_id, true);
        $criteria->compare('obj1_name', $this->obj1_name, true);
        $criteria->compare('obj1_url_key', $this->obj1_url_key, true);
        $criteria->compare('obj2_id', $this->obj2_id, true);
        $criteria->compare('obj2_name', $this->obj2_name, true);
        $criteria->compare('obj2_url_key', $this->obj2_url_key, true);
        $criteria->compare('package_id', $this->package_id);
        $criteria->compare('cp_id', $this->cp_id);
        $criteria->compare('genre_id', $this->genre_id);
        $criteria->compare('sharing_rate', $this->sharing_rate);
        $criteria->compare('promotion', $this->promotion, true);
        //$criteria->compare('note', $this->note, false);
        $criteria->compare('return_code', $this->return_code, true);

        if (!empty($this->created_time)) {
            $criteria->addBetweenCondition('t.created_time', $this->created_time['from'], $this->created_time['to']);
        }
        /* if($this->note && $this->note == '<>PENDING_EXT'){
        	$criteria->addCondition("note IS NULL OR note <> 'PENDING_EXT'");
        }

        $criteria->addCondition(" NOT (transaction = 'play_album' AND obj2_id <> 0) "); */

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array('defaultOrder' => 'created_time DESC, id DESC'),
                    'pagination' => array(
                        'pageSize' => $limit,
                    ),
                ));
    }

    public function musicgiftReport($time, $price = 2, $type_send = 0) {
        if (is_array($time)) {
            $from = $time['from'] . " 00:00:00";
            $to = $time['to'] . " 23:59:59";
        } else {
            $from = $time . " 00:00:00";
            $to = $time . " 23:59:59";
        }
        $where = " transaction='gift_song' AND created_time >= '{$from}' AND created_time <= '{$to}' ";
        if ($price == 1) {
            $where .= " AND price > '0'";
        } elseif ($price == 0) {
            $where .= " AND price = '0'";
        } else {
            $where .= " AND 1=1";
        }
        if($type_send){
            $where .= " AND channel='{$type_send}'";
        }
        $sql = "SELECT
                    date(created_time) AS m,
                    COUNT(*) AS total,
                    SUM(CASE WHEN return_code ='0' THEN 1 ELSE 0 END) AS total_success,
                    SUM(CASE WHEN return_code <> '0' THEN 1 ELSE 0 END) AS total_fail,
                    COUNT(DISTINCT user_phone) AS total_phone
                FROM user_transaction
                WHERE $where
                GROUP BY m ORDER BY m DESC
         ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function getTransactionNames()
    {
        switch ($this->transaction){
            case 'subscribe':
                return 'Đăng ký';
            break;
            case 'unsubscribe':
                return 'Hủy đăng ký';
                break;
            case 'download_song':
                return 'Tải bài hát';
                break;
            case 'download_video':
                return 'Tải video';
                break;
            case 'play_song':
                return 'Nghe bài hát';
                break;
            case 'play_video':
                return 'Xem video';
                break;
            case 'extend_remain':
            case 'extend_subscribe':
            case 'extend_subscribe_level1':
                return 'Gia hạn';
                break;
        }

    }

}
