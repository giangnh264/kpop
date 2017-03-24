<?php
class KpiController extends  Controller
{
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
	
	public function actionLogAction()
	{
		$model = new AdminLogActionModel("search");
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['AdminLogActionModel'])){
			$model->attributes = $_GET['AdminLogActionModel'];
		}
		$action = AdminLogActionModel::model()->getList();
		$this->render('logAction',compact("model","action"));
	}
	
	public function actionViewLogAction($id)
	{
		$model = AdminLogActionModel::model()->findByAttributes(array("id"=>$id));
		$this->render('viewLogAction',compact("model"));
	}
	
	public function actionLogSms()
	{
		if (is_array($this->time)) {
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
		} else {
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
		}
		$sql = "SELECT
			DATE_FORMAT(send_datetime,'%Y-%m-%d %H:00') AS date,
			COUNT(*) AS total,
			SUM(CASE WHEN status = '0|success' THEN 1 ELSE 0 END) as success,
			SUM(CASE WHEN status <> '0|success' THEN 1 ELSE 0 END) as failed
			FROM log_sms_mt
			WHERE send_datetime >='{$from}' and send_datetime < '{$to}'
			GROUP BY date
			ORDER BY date desc";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		$this->render('logSMS', compact("data"));		
	}
	
	public function actionSyncStatus()
	{
		if (is_array($this->time)) {
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
		} else {
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
		}
		$sql = "SELECT
			date(created_time) AS date,
			COUNT(*) AS total,
			SUM(CASE WHEN system_action = 'UNSUB' THEN 1 ELSE 0 END) as total_unsub,
			SUM(CASE WHEN system_action = 'LOCK' THEN 1 ELSE 0 END) as total_lock,
			SUM(CASE WHEN system_action = 'UNLOCK' THEN 1 ELSE 0 END) as total_unlock
			FROM log_sync_vasgate
			WHERE created_time >='{$from}' and created_time < '{$to}'
			GROUP BY date
			ORDER BY date desc";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		$this->render('logSyncStatus', compact("data"));		
	}
}

