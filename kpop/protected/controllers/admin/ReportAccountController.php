<?php
class ReportAccountController extends Controller
{
	public $time;
	public $timeLabel;
	public function init() {
		parent::init();
		$this->pageTitle = Yii::t('admin', "Thống kê khối lượng công việc. ") ;
		
		if (isset($_GET['datetime']) && $_GET['datetime'] != "") {
			$createdTime = $_GET['datetime'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate." 00:00:00", 'to' => $toDate." 23:59:59");
			} else {
				$time = explode("/", trim($_GET['datetime']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time." 00:00:00", 'to' => $time." 23:59:59");
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d", strtotime($startDay));
			$toDate = date("Y-m-d");
			$this->time = array('from' => $fromDate." 00:00:00", 'to' => $toDate." 23:59:59");
		}
		//
		$timeLabel = array();
		$timeFrom = date('Y-m-d',strtotime($this->time['from']));
		$timeTo = date('Y-m-d',strtotime($this->time['to']));
		while ($timeFrom<=$timeTo){
			$timeLabel[] = $timeFrom;
			$timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
		}
		$this->timeLabel = $timeLabel;
		$this->timeLabel = array_reverse($this->timeLabel);
		/* echo '<pre>';print_r($this->time);
		echo '<pre>';print_r($this->timeLabel); */
	}
	public function actionIndex()
	{
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',$pageSize);
		$time = $this->time;
		$userBeReport = $this->getAllUserByRole();
		$data = array();
		if($userBeReport){
			foreach ($userBeReport as $key => $value){
				$data[] = array(
						'user_id'=>$value['userid'],
						'username'=>$value['username'],
						'add_video_count'=>$this->getCountVideo($value['userid'], $time),
						'add_song_count'=>$this->getCountSong($value['userid'], $time),
						'approved'=>$this->getCountApproved($value['userid'], $time, 1),
						'not_approved'=>$this->getCountApproved($value['userid'], $time, 0),
				);
			}
		}
		//echo '<pre>';print_r($data);
		$data = new CArrayDataProvider($data, array(
				'pagination'=>array(
						'pageSize'=> $pageSize,
				),
		));
		$this->render('index', array(
				'data'=>$data,
				'pageSize'=>$pageSize,
				'time'=>$time
		));
	}
	protected function getAllUserByRole($role='CTVRole')
	{
		$sql = "SELECT c1.userid, c2.username
				FROM admin_access_assignments c1
				LEFT JOIN admin_user c2 ON c1.userid=c2.id
				WHERE c1.itemname='$role'";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	protected function getCountVideo($createdUserId, $time)
	{
		$sql = "SELECT count(*) 
				FROM video 
				WHERE created_by = $createdUserId AND created_time >='{$time['from']}' AND created_time <='{$time['to']}'";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	protected function getCountSong($createdUserId, $time)
	{
		$sql = "SELECT count(*) 
				FROM song 
				WHERE created_by = $createdUserId AND created_time >='{$time['from']}' AND created_time <='{$time['to']}'";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	protected function getCountApproved($userId, $time, $status=0)
	{
		$sql = "SELECT count(*) 
				FROM content_approve
				WHERE admin_id = '$userId' AND created_time >='{$time['from']}' AND created_time <='{$time['to']}' AND status=$status
		";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
}