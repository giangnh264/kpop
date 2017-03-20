<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MonitoringController
 *
 * @author Nguyen Thanh Long
 */
class MonitoringController extends Controller {

    public $time;

    public function init() {
        parent::init();
        if (isset($_GET['time']) && $_GET['time'] != "") {
            $createdTime = $_GET['time'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['time']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $this->time = $time;
            }
        } else {
            $fromDate = $toDate = date("Y-m-d");
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
    }

    public function actionDetect() {
        if (is_array($this->time)) {
            $from = $this->time['from'] . " 00:00:00";
            $to = $this->time['to'] . " 23:59:59";
        } else {
            $from = $this->time . " 00:00:00";
            $to = $this->time . " 23:59:59";
        }
        $sql = "SELECT
                    DATE_FORMAT(loged_time,'%Y-%m-%d %H:00') AS date,
                    COUNT(*) AS total,
                    SUM(CASE WHEN phone = '' THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN phone <> '' THEN 1 ELSE 0 END) as success
                FROM log_detect_msisdn
                WHERE loged_time >='{$from}' and loged_time < '{$to}'
                GROUP BY date
                ORDER BY date desc";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $ip_fail = "select login_ip from log_detect_msisdn where (phone = '' or phone is null) and loged_time >='{$from}' and loged_time < '{$to}' group by login_ip";
        $list_ip = Yii::app()->db->createCommand($ip_fail)->queryAll();
        $this->render('detect', array('data' => $data, 'ips' => $list_ip,));
    }

	
	 public function actionKPI() {
		 
		 
       if (isset($_GET['kpi']['date']) && $_GET['kpi']['date'] != "") {
			$createdTime = $_GET['kpi']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['kpi']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
       
	    $arr_res = $arr_date = array();
		$date = $this->time['from'];
		$count_date = 0;
		
		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_kpi where report_date='$date'";
			$results =  Yii::app()->db->createCommand($sql)->queryAll();
			foreach($results as $result){
				if(!$sum)
					$arr_res[$count_date][$result['field_name']] = $result['field_value'];
				else
					$arr_res[0][$result['field_name']] += $result['field_value'];
			}
			$arr_date[] = $date;
			$date = date('Y-m-d',strtotime("+1 day",strtotime("$date")));
			$count_date++;
		}
		
		//export
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			$this->layout=false;
			if(isset($_GET['dev']) && $_GET['dev']==1){
				//
			}else{
				header('Content-type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=kpi.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('_export_raw_kpi',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
        $this->render('kpi',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
		));
    }
	
    public function actionSubscribe() {
        if (is_array($this->time)) {
            $from = $this->time['from'] . " 00:00:00";
            $to = $this->time['to'] . " 23:59:59";
        } else {
            $from = $this->time . " 00:00:00";
            $to = $this->time . " 23:59:59";
        }
        $packge = (int) CHtml::encode(Yii::app()->request->getParam('packge', 0));
        $action = CHtml::encode(Yii::app()->request->getParam('act', 0));
        $time_note = CHtml::encode(Yii::app()->request->getParam('time_note', 0));

        $phone_list = null;
        $title = '';
        if ($action && $time_note) {
            $time_note = substr($time_note, 0, -2);
            $start = $time_note . "00:00";
            $end = $time_note . "59:59";
            $wh = '';
            if ($action == 'balance') {
                $title = "Balace too low";
                $wh = "AND return_code = 1";
            } elseif ($action == 'false') {
                $title = "Failed";
                $wh = "AND return_code <> 0 AND return_code <> 1";
            }
            $sql_detail = "SELECT user_phone, return_code, count(*) as cnt
                    FROM user_transaction
                    WHERE created_time >='{$start}'
                        AND created_time <= '{$end}'
                        AND transaction = 'subscribe'
                        $wh
                    GROUP BY user_phone
                    ORDER BY created_time desc";
//            var_dump($sql_detail);die;
            $phone_list = Yii::app()->db->createCommand($sql_detail)->queryAll();
        }

        $where = '';
        if ($packge) {
            $where = "AND package_id = '{$packge}'";
        }
        $sql = "SELECT
                    DATE_FORMAT(created_time,'%Y-%m-%d %H:00') AS date,
                    COUNT(*) AS total,
                    SUM(CASE WHEN return_code = 1 THEN 1 ELSE 0 END) as balance,
                    SUM(CASE WHEN (return_code <> 0 and return_code <> 1) THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN return_code = 0 THEN 1 ELSE 0 END) as success
                FROM user_transaction
                WHERE created_time >='{$from}'
                    AND created_time < '{$to}'
                    AND transaction = 'subscribe'
                    $where
                GROUP BY date
                ORDER BY date desc";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $sql_err = "SELECT return_code, note, count(*) as total
                    FROM `user_transaction`
                    WHERE created_time >='{$from}'
                        AND created_time < '{$to}'
                        AND transaction = 'subscribe'
                        AND created_time <> 0
                        AND return_code <> 0
                        $where
                    GROUP BY return_code;";
        $errors = Yii::app()->db->createCommand($sql_err)->queryAll();

        $packge = PackageModel::model()->findAllByAttributes(array('status' => 1));

        $this->render('subscribe', array('data' => $data, 'errors' => $errors, 'packge' => $packge, 'phone_list' => $phone_list, 'title' => $title));
    }

    public function actionExtend() {
        if (is_array($this->time)) {
            $from = $this->time[
                    'from'] . " 00:00:00";
            $to = $this->time['to'] . " 23:59:59";
        } else {
            $from = $this->time . " 00:00:00";
            $to = $this->time . " 23:59:59";
        }
        $sql = "SELECT
                    DATE_FORMAT(created_time,'%Y-%m-%d %H:00') AS date,
                    COUNT(*) AS total,
                    SUM(CASE WHEN return_code = 1 THEN 1 ELSE 0 END) as balance,
                    SUM(CASE WHEN (return_code <> 0 and return_code <> 1) THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN return_code = 0 THEN 1 ELSE 0 END) as success
                FROM user_transaction
                WHERE created_time >='{$from}'
                    AND created_time < '{$to}'
                    AND transaction IN ('extend_subscribe','extend_subscribe_level1','extend_remain')
                GROUP BY date
                ORDER BY date desc";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $sql_err = "SELECT return_code, note, count(*) as total
                    FROM `user_transaction`
                    WHERE created_time >='{$from}'
                        AND created_time < '{$to}'
                        AND transaction = 'subscribe_ext'
                        AND created_time <> 0
                        AND return_code <> 0
                    GROUP BY return_code;";
        $errors = Yii::app()->db->createCommand($sql_err)->queryAll();

        $packge = PackageModel::model()->findAllByAttributes(array('status' => 1));

        $this->render('extend', array('data' => $data, 'errors' => $errors, 'packge' => $packge));
    }

    public function actionUnSubscribe() {
        if (is_array($this->time)) {
            $from = $this->time['from'] . " 00:00:00";
            $to = $this->time['to'] . " 23:59:59";
        } else {
            $from = $this->time . " 00:00:00";
            $to = $this->time . " 23:59:59";
        }
        $packge = (int) CHtml::encode(Yii::app()->request->getParam('packge', 0));
        $action = CHtml::encode(Yii::app()->request->getParam('act', 0));
        $time_note = CHtml::encode(Yii::app()->request->getParam('time_note', 0));

        $phone_list = null;
        $title = '';
        if ($action && $time_note) {
            $time_note = substr($time_note, 0, -2);
            $start = $time_note . "00:00";
            $end = $time_note . "59:59";
            $wh = '';
            if ($action == 'false') {
                $title = "Failed";
                $wh = "AND return_code <> 0 AND return_code <> 1";
            }
            $sql_detail = "SELECT user_phone, return_code, count(*) as cnt
                    FROM user_transaction
                    WHERE created_time >='{$start}'
                        AND created_time <= '{$end}'
                        AND transaction = 'unsubscribe'
                        $wh
                    GROUP BY user_phone
                    ORDER BY created_time desc";
//            var_dump($sql_detail);die;
            $phone_list = Yii::app()->db->createCommand($sql_detail)->queryAll();
        }

        $where = '';
        if ($packge) {
            $where = "AND package_id = '{$packge}'";
        }
        $sql = "SELECT
                    DATE_FORMAT(created_time,'%Y-%m-%d %H:00') AS date,
                    COUNT(*) AS total,
                    SUM(CASE WHEN (return_code <> 0 and return_code <> 1) THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN return_code = 0 THEN 1 ELSE 0 END) as success
                FROM user_transaction
                WHERE created_time >='{$from}'
                    AND created_time < '{$to}'
                    AND transaction = 'unsubscribe'
                    $where
                GROUP BY date
                ORDER BY date desc";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $sql_err = "SELECT return_code, note, count(*) as total
                    FROM `user_transaction`
                    WHERE created_time >='{$from}'
                        AND created_time < '{$to}'
                        AND transaction = 'unsubscribe'
                        AND created_time <> 0
                        AND return_code <> 0
                        $where
                    GROUP BY return_code;";
        $errors = Yii::app()->db->createCommand($sql_err)->queryAll();

        $packge = PackageModel::model()->findAllByAttributes(array('status' => 1));

        $this->render('unsubscribe', array('data' => $data, 'errors' => $errors, 'packge' => $packge, 'phone_list' => $phone_list, 'title' => $title));
    }

    public function actionCharge(){
        if (is_array($this->time)) {
            $from = $this->time[
                'from'] . " 00:00:00";
            $to = $this->time['to'] . " 23:59:59";
        } else {
            $from = $this->time . " 00:00:00";
            $to = $this->time . " 23:59:59";
        }
        $sql = "SELECT
                    DATE_FORMAT(created_time,'%Y-%m-%d %H:00') AS date,
                    COUNT(*) AS total,
                    SUM(CASE WHEN return_code = 1 THEN 1 ELSE 0 END) as balance,
                    SUM(CASE WHEN (return_code <> 0 and return_code <> 1) THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN return_code = 0 THEN 1 ELSE 0 END) as success
                FROM user_transaction
                WHERE created_time >='{$from}'
                    AND created_time < '{$to}'
                    AND transaction IN ('subscribe_ext', 'extend_subscribe', 'subscribe')
                GROUP BY date
                ORDER BY date desc";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $sql_err = "SELECT return_code, note, count(*) as total
                    FROM `user_transaction`
                    WHERE created_time >='{$from}'
                        AND created_time < '{$to}'
                    AND transaction IN ('subscribe_ext', 'extend_subscribe', 'subscribe')
                        AND created_time <> 0
                        AND return_code <> 0
                    GROUP BY return_code;";
        $errors = Yii::app()->db->createCommand($sql_err)->queryAll();

        $packge = PackageModel::model()->findAllByAttributes(array('status' => 1));

        $this->render('charge', array('data' => $data, 'errors' => $errors, 'packge' => $packge));

    }



}
