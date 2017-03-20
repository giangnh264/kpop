<?php
@ini_set("max_execution_time", 300);
@ini_set("memory_limit", "1024M");
class ReportsController extends Controller {

	public $cpList;
	public $categoryList;
	public $time;
    public $pageLabel;


	public function init() {
		parent::init();
		$this->categoryList = AdminGenreModel::model()->gettreelist(2);
		$this->cpList = AdminCpModel::model()->findAll();
                $this->pageLabel = '';
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate, 'to' => $toDate);
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = $time;
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d", strtotime($startDay));
			$toDate = date("Y-m-d");
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
	}
	public function actionDailyReportRevenue()
	{
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;
		
		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_doanh_thu.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('_export_daily_report_revenue',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('daily_report_revenue',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
		));
	}
	public function actionDailyReportMsisdn()
	{
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;
		
		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_thue_bao.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('_export_daily_report_msisdn',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('daily_report_msisdn',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
		));
	}
	public function actionDailyReport()
	{
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		
		$sum = (!isset($_GET['sum']))?0:1;
		
		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_chung.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('_export_raw_dailyreport',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('daily_report',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
		));
	}
	public function actionIndex() {
		$this->forward('reports/song', true);
	}

	public function actionSong() {
		$model = new AdminStatisticSongModel('searchGlobal');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['songreport'])) {
			$model->attributes = $_GET['songreport'];
		}

		$model->setAttribute("date", $this->time);

		if ($this->cpId != 0) {
			$model->setAttribute("cp_id", $this->cpId);
		}
		$genre_id = isset($model->genre_id)?$model->genre_id:null;
		$model->unsetAttributes(array('genre_id'));
		$owner = isset($_GET['songreport']['song_owner'])?$_GET['songreport']['song_owner']:null;
		$data = $model->searchGlobal($genre_id,$owner);
		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');
			$label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'played_count' => Yii::t('admin', 'Lượt nghe'),
                'played_count_web' => Yii::t('admin', 'Nghe trên web'),
                'played_count_wap' => Yii::t('admin', 'Nghe trên wap'),
                'played_count_api_ios' => Yii::t('admin', 'Nghe trên IOS'),
                'played_count_api_android' => Yii::t('admin', 'Nghe trên ANDROID'),
                'downloaded_count' => Yii::t('admin', 'Lượt tải'),
                'downloaded_count_web' => Yii::t('admin', 'Tải trên web'),
                'downloaded_count_wap' => Yii::t('admin', 'Tải trên wap'),
                'downloaded_count_api_ios' => Yii::t('admin', 'Tải trên IOS'),
                'downloaded_count_api_android' => Yii::t('admin', 'Tải trên ANDROID'),
			);

			$title = Yii::t('admin', 'Thống kê bài hát');
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}
		$data = new CArrayDataProvider($data, array(
				'pagination'=>array(
						'pageSize'=> 30,
				),
		));
		$this->render("song", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
            'data' => $data,
		));
	}

	public function actionSongdetail() {
		@ini_set('memory_limit', "1024M");
		$model = new AdminStatisticSongModel('searchDetail');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
		$model->setAttribute("date", $this->time);
		if ($this->cpId != 0) {
			$model->setAttribute("cp_id", $this->cpId);
		}
		$sort = null;
		if(isset($_GET['AdminStatisticSongModel_sort'])){
			$sort = explode('.', $_GET['AdminStatisticSongModel_sort']);
		}
		//echo "<pre>";print_r(json_decode(CJSON::encode($data->getData())));exit();
		$export = $_GET['export'];
		
		$data = $model->searchDetail($_GET['songreport']['genre_id'],$_GET['songreport']['song_owner'],$sort,$export);
		if($export){
			$this->layout=false;
			$fileName = "Thong_ke_baihat";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_songDetail", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
            'data'=>$data,
		));
			exit();
		}
		$this->render("songDetail", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
            'data'=>$data,
		));
	}

	public function actionVideo() {
		$model = new AdminStatisticVideoModel('searchGlobal');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
		$model->setAttribute("date", $this->time);
		if ($this->cpId != 0) {
			$model->setAttribute("cp_id", $this->cpId);
		}
		$genre_id = isset($model->genre_id)?$model->genre_id:null;
		$model->unsetAttributes(array('genre_id'));
		$owner = isset($_GET['songreport']['video_owner'])?$_GET['songreport']['video_owner']:null;
		$data = $model->searchGlobal($genre_id, $owner);

		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');
			$label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'played_count' => Yii::t('admin', 'Lượt Xem'),
                'played_count_wap' => Yii::t('admin', 'Xem trên wap'),
                'played_count_api_ios' => Yii::t('admin', 'Xem trên IOS'),
                'played_count_api_android' => Yii::t('admin', 'Xem trên ANDROID'),
                'downloaded_count' => Yii::t('admin', 'Lượt tải'),
                'downloaded_count_web' => Yii::t('admin', 'Tải trên web'),
                'downloaded_count_wap' => Yii::t('admin', 'Tải trên wap'),
                'downloaded_count_api_ios' => Yii::t('admin', 'Tải trên IOS'),
                'downloaded_count_api_android' => Yii::t('admin', 'Tải trên ANDROID'),
			);

			$title = Yii::t('admin', 'Thống kê Video');
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}
		$data = new CArrayDataProvider($data, array(
				'pagination'=>array(
						'pageSize'=> 30,
				),
		));
		$this->render("video", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
            'data' => $data,
		));
	}

	public function actionVideodetail() {
		$model = new AdminStatisticVideoModel('searchDetail');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
		$model->setAttribute("date", $this->time);
		if ($this->cpId != 0) {
			$model->setAttribute("cp_id", $this->cpId);
		}
		$sort = null;
		if(isset($_GET['AdminStatisticVideoModel_sort'])){
			$sort = explode('.', $_GET['AdminStatisticVideoModel_sort']);
		}
		//echo "<pre>";print_r(json_decode(CJSON::encode($data->getData())));exit();
		$data = $model->searchDetail($_GET['songreport']['genre_id'],$_GET['songreport']['video_owner'], $sort);
		$this->render("videoDetail", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
            'data'=>$data,
		));
	}

	public function actionDaily() {
		$totalListenSong = AdminUserTransactionModel::model()->getTotalTransByTime('play_song', '');
		$totalDownloadSong = AdminUserTransactionModel::model()->getTotalTransByTime('download_song', '');
		$totalPlayVideo = AdminUserTransactionModel::model()->getTotalTransByTime('play_video', '');
		$totalDownloadVideo = AdminUserTransactionModel::model()->getTotalTransByTime('download_video', '');
		$totalSubsctibe = AdminUserTransactionModel::model()->getTotalTransByTime('subscribe', '');
		$totalUnsubsctibe = AdminUserTransactionModel::model()->getTotalTransByTime('unsubscribe', '');
		$totalSubsctibeExt = AdminUserTransactionModel::model()->getTotalTransByTime('subscribe_ext', '');
		$totalSubsFree = AdminUserTransactionModel::model()->getTotalTransFreeByTime('subscribe', '');

		$totalRev = AdminUserTransactionModel::model()->getTotalRevByTime(null, '');

		$this->render("daily", array(
            'totalListenSong' => $totalListenSong,
            'totalDownloadSong' => $totalDownloadSong,
            'totalPlayVideo' => $totalPlayVideo,
            'totalDownloadVideo' => $totalDownloadVideo,
            'totalSubsctibe' => $totalSubsctibe,
            'totalUnsubsctibe' => $totalUnsubsctibe,
            'totalSubsctibeExt' => $totalSubsctibeExt,
            'totalSubsFree' => $totalSubsFree,
            'totalRev' => $totalRev,
		));
	}

	public function actionDailyTime() {
		$time = $this->time;
		$allReport = AdminUserTransactionModel::model()->getAllByTime($time);

		$totalListenSong = AdminUserTransactionModel::model()->getTotalTransByTime('play_song', $time);
		$totalDownloadSong = AdminUserTransactionModel::model()->getTotalTransByTime('download_song', $time);
		$totalPlayVideo = AdminUserTransactionModel::model()->getTotalTransByTime('play_video', $time);
		$totalDownloadVideo = AdminUserTransactionModel::model()->getTotalTransByTime('download_video', $time);
		$totalSubsctibe = AdminUserTransactionModel::model()->getTotalTransByTime('subscribe', $time);
		$totalUnsubsctibe = AdminUserTransactionModel::model()->getTotalTransByTime('unsubscribe', $time);
		$totalSubsctibeExt = AdminUserTransactionModel::model()->getTotalTransByTime('subscribe_ext', $time);
		$totalSubsFree = AdminUserTransactionModel::model()->getTotalTransFreeByTime('subscribe', $time);

		$totalRev = AdminUserTransactionModel::model()->getTotalRevByTime(null, $time);

		$this->render("dailyTime", array(
            'totalListenSong' => $totalListenSong,
            'totalDownloadSong' => $totalDownloadSong,
            'totalPlayVideo' => $totalPlayVideo,
            'totalDownloadVideo' => $totalDownloadVideo,
            'totalSubsctibe' => $totalSubsctibe,
            'totalUnsubsctibe' => $totalUnsubsctibe,
            'totalSubsctibeExt' => $totalSubsctibeExt,
            'totalSubsFree' => $totalSubsFree,
            'totalRev' => $totalRev,
            'allReport' => $allReport,
		));
	}

	public function actionRevenue() {
		$model = new AdminStatisticRevenueModel('search');
		$model->unsetAttributes();  // clear any default values
		$model->setAttribute("date", $this->time);

		$isExport = Yii::app()->request->getParam('export', null);
		// reset page site in session
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize', $pageSize);
		if ($isExport) {
			Yii::app()->user->setState('pageSize', 999999);
			$data = $model->search()->getData();
			ini_set('display_errors', 'On');
			$label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'song_revenue' => Yii::t('admin', 'Doanh thu bài hát - tất cả'),
                'song_play_revenue' => Yii::t('admin', 'Doanh thu bài hát - Nghe '),
                'song_download_revenue' => Yii::t('admin', 'Doanh thu bài hát - Tải '),
                'video_revenue' => Yii::t('admin', 'Doanh thu video - Tất cả'),
                'video_play_revenue' => Yii::t('admin', 'Doanh thu video - Xem'),
                'video_download_revenue' => Yii::t('admin', 'Doanh thu video - Tải'),
                'ringtone_revenue' => Yii::t('admin', 'Doanh thu nhạc chuông'),
                'rbt_revenue' => Yii::t('admin', 'Doanh thu nhạc chờ'),
                'album_revenue' => Yii::t('admin', 'Doanh thu Album'),
                'subscribe_revenue' => Yii::t('admin', 'Đăng ký'),
                'subscribe_ext_revenue' => Yii::t('admin', 'Gia hạn'),
                'total_revenue' => Yii::t('admin', 'Tổng doanh thu'),
			);

			$title = Yii::t('admin', 'Thống kê doanh thu từ {from} tới {to}', array('{from}' => $this->time['from'], '{to}' => $this->time['to']));
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}

		$this->render("revenue", array(
            'model' => $model,
			'pageSize'=>$pageSize
		));
	}

	public function actionRevenueCP() {
		if ($this->cpId != 0) {
			$cpId = $this->cpId;
		} else {
			if (isset($_GET['songreport']['cp_id'])) {
				$cpId = $_GET['songreport']['cp_id'];
			} else {
				$cpArray = json_decode(CJSON::encode($this->cpList), true);
				$cpId = $cpArray[0]['id'];
			}
		}
		$packageId = Yii::app()->request->getParam('package',3);
		$packageList = CHtml::listData(PackageModel::model()->findAll(), 'id', 'code');

		$data = AdminUserTransactionModel::model()->getTotalRevByCP($cpId, $this->time,$packageId);
		$cpName = AdminCpModel::model()->findByPk($cpId);

		//echo "<pre>";print_r($data);exit();
		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');
			$this->layout=false;
			/* $dataExp = array();
			foreach ($data['cpTrans'] as $item) {
				$item['rev_sub'] = $data['revPackage'][$item['m']];
				$revCp = (($item['streaming_cp'] + $item['download_cp']) / $item['total_streaming_download']) * $item['rev_sub'] * 0.3;
				$item['rev_cp'] = round($revCp, 2);
				$dataExp[] = $item;
			}
			//echo "<pre>";print_r($dataExp);exit();

			$label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'streaming_cp' => Yii::t('admin', 'Nghe của CP'),
                'total_streaming' => Yii::t('admin', 'Tổng lượt nghe'),
                'download_cp' => Yii::t('admin', 'Tải của CP'),
                'total_download' => Yii::t('admin', 'Tổng lượt tải'),
                'total_streaming_download' => Yii::t('admin', 'Tổng Nghe + Tải'),
                'rev_sub' => Yii::t('admin', 'DT gói cước'),
                'rev_cp' => Yii::t('admin', 'DT CP'),
			);

			$title = Yii::t('admin', 'Thống kê doanh thu CP {name} (gói cước)', array('{name}' => $cpName->name));
			$excelObj = new ExcelExport($dataExp, $label, $title);
			$excelObj->export(); */
			$cs=Yii::app()->clientScript;
			$cs->scriptMap=array(
					'srbac.css'=>false,
			);
			$fileName = "Thống kê doanh thu CP {$cpName->name} (gói cước)";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_revenueCp", array(
					'data' => $data,
					'cpList' => $this->cpList,
					'cpName' => $cpName,
					'cpId' => $cpId,
					'packageId' => $packageId,
					'packageList' => $packageList,
			));
			exit;
		}

		$this->render("revenueCp", array(
            'data' => $data,
            'cpList' => $this->cpList,
            'cpName' => $cpName,
            'cpId' => $cpId,
            'packageId' => $packageId,
            'packageList' => $packageList,
		));
	}
	// thong ke ban quyen

	/* Report copyright content of provider
     *
     * */
	public function actionCopyrightCP() {

		if (is_array($this->time)) {
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$time['from'] = $this->time['from'] . " 00:00:00";
			$time['to'] = $this->time['to'] . " 23:59:59";
		} else {
			$tt = $this->time;
			$time['from'] = $this->time . " 00:00:00";
			$time['to'] = $this->time . " 23:59:59";
		}
		$package = Yii::app()->request->getParam('package', 1);
		$model = new AdminStatisticSongModel('searchCopyrightCP');

		$model->unsetAttributes();  // clear any default values
		$model->setAttribute("date", $time);
		$ccp_id = $this->ccpId;
		$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp' => $ccp_id, 'status' => 1));
		$ccpList = AdminCcpModel::model()->findAll();

		if ($this->levelAccess <= 2) {
			$ccp_id = Yii::app()->request->getParam('ccp_id', null);
			$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp' => $ccp_id, 'status' => 1));
		}
		$copyright_id = $copyright['id'];
		$data = null;
		$copyrightType = Yii::app()->request->getParam('ccp_type', 0);
		if ($ccp_id) {
			$data = $model->searchCopyrightCP($ccp_id, $time, $copyrightType);
			$ccp = AdminCcpModel::model()->findByPk($ccp_id);
		} else {
			$ccp = null;
		}
		$cp_vega_id = 1;
		$sVega = AdminUserTransactionModel::model()->getTotalRevByCP($cp_vega_id, $this->time, $package);

		$ssVega = array();
		foreach ($sVega['cpTrans'] as $key => $value) {
			$ssVega["{$value["m"]}"] = $value;
		}
		$revenuePackage = $sVega['revPackage'];
		if (YII_DEBUG) {
			echo '<pre>';
			print_r($ssVega);
		}
		if (Yii::app()->request->getParam('export', false)) {
			$this->layout = false;
			$cs = Yii::app()->clientScript;
			$cs->scriptMap = array(
				'srbac.css' => false,
			);
			$fileName = "Thong_ke_doanh_thu_ban_quyen";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_copyrightCP", array(
				'data' => $data,
				'ccp' => $ccp,
				'ccp_id' => $ccp_id,
				'ccpList' => $ccpList,
				'copyrightType' => $copyrightType,
				'ssVega' => $ssVega,
				'revenuePackage' => $revenuePackage
			));
			exit();
		}
		$this->render("copyrightCP", array(
			'data' => $data,
			'ccp' => $ccp,
			'ccp_id' => $ccp_id,
			'ccpList' => $ccpList,
			'copyrightType' => $copyrightType,
			'ssVega' => $ssVega,
			'revenuePackage' => $revenuePackage,
			'package' => $package,
		));
	}
	public function actionCopyrightCPArtist() {

		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$time['from'] = $this->time['from'] . " 00:00:00";
			$time['to'] = $this->time['to'] . " 23:59:59";
		}else{
			$tt = $this->time;
			$time['from'] = $this->time . " 00:00:00";
			$time['to'] = $this->time . " 23:59:59";
		}
		$artist = Yii::app()->request->getParam('artist',0);
		$composer = Yii::app()->request->getParam('composer',0);
		$cp = Yii::app()->request->getParam('cp',0);
		$model = new AdminStatisticSongModel('searchCopyrightCP');
		$model->unsetAttributes();  // clear any default values
		$model->setAttribute("date", $time);

		$data = null;
		$data = $model->searchRevenueCPArtist($time, $artist, $composer, $cp);
		if (Yii::app()->request->getParam('export', false)) {
			//ini_set('display_errors', 'On');
			$this->layout=false;
			$fileName = "Thong_ke_doanh_thu_goi";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_copyrightCPArtist", array(
					'data' => $data,
					'artist' => $artist,
					'composer' => $composer,
					'cp' =>$cp,
			));
			exit();
		}
		//$data = null;
		$this->render("copyrightCPArtist", array(
            'data' => $data,
			'artist' => $artist,
			'composer' => $composer,
			'cp' =>$cp,
		));
	}
	/* Report CCP Song Contents
	 *
	 * */

	public function actionCCPSongdetail() {
		$model = new AdminStatisticSongModel('SearchCCPSongDetail');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
		$model->setAttribute("date", $this->time);


		//$ccpList =  AdminCcpModel::model()->findAll();
		$ccp_id = $this->ccpId;
		$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		$ccpList =  AdminCcpModel::model()->findAll();

		if($this->levelAccess <=2){
			$ccp_id = Yii::app()->request->getParam('ccp_id',null);
			$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		}
		$copyright_id = $copyright['id'];
		//$model->setAttribute("ccp_id", $copyright_id);

		$data = null;
		$copyrightType = Yii::app()->request->getParam('ccp_type',0);
		if($copyrightType==0){
			$model->setAttribute("ccp_id",$copyright_id);
		}else{
			$model->setAttribute("ccpr_id",$copyright_id);
		}
		if($copyright_id){
			//$data = $model->SearchCCPSongDetail($copyright_id, $copyrightType);
			if(isset($_GET['Export']) && $_GET['Export']=='Export'){
				$model->size_export_list = 65000;
			}
			$data = $model->SearchCCPSongDetail($ccp_id,$copyrightType);
			$ccp = AdminCcpModel::model()->findByPk($ccp_id);
		}else{
			$ccp = null;
		}
                if(isset($ccp))
                    $this->pageLabel = Yii::t('admin', "Chi tiết bài hát từ {from} tới {to} CCP {CCPNAME}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to'],'{CCPNAME}'=>$ccp->name));
                else
                    $this->pageLabel = Yii::t('admin', "Chi tiết bài hát từ {from} tới {to} CCP {CCPNAME}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to'],'{CCPNAME}'=>''));
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			if(!YII_DEBUG){
				$this->layout=false;
				$fileName = "Chi_Tiet_Bai_Hat_".date('d_m_Y');
				header('Content-type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=$fileName.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}else{
				echo '<pre>';print_r($data);
			}
			@ini_set('max_execution_time', 3000);
			
			$this->render("_export_CCPsongDetail", array(
					'data' => $data,
					'ccp' => $ccp,
			));
			exit();
		}
		$this->render("CCPsongDetail", array(
			'model'=>$model,
            'data' => $data,
			'ccp' => $ccp,
			'ccp_id' => $ccp_id,
			'ccpList' =>$ccpList,
			'copyrightType'=>$copyrightType
		));
	}
	/* bao cao chi tiet theo ca sy
	 *
	 * */

	public function actionRevenueSongdetailArtist() {
		$model = new AdminStatisticSongModel();
		$model->unsetAttributes();  // clear any default values
		
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$time['from'] = $this->time['from'] . " 00:00:00";
			$time['to'] = $this->time['to'] . " 23:59:59";
		}else{
			$tt = $this->time;
			$time['from'] = $this->time . " 00:00:00";
			$time['to'] = $this->time . " 23:59:59";
		}
		$artist = Yii::app()->request->getParam('artist',0);
		$composer = Yii::app()->request->getParam('composer',0);
		$cp = Yii::app()->request->getParam('cp',0);
		$song_name = Yii::app()->request->getParam('song_name','');
	
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			$model->size_export_list = 65000;
		}
		
		$data = $model->SearchRevenueSongDetailArtist($song_name, $artist, $composer, $cp, $time);
		
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			@ini_set('max_execution_time', 3000);
			$this->layout=false;
			$fileName = "Chi_Tiet_Bai_Hat_casy".date('d_m_Y');
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_revenue_songDetail_artist", array(
					'data' => $data,
			));
			exit();
		}
		$this->render("revenueSongDetailArtist", array(
			'model'=>$model,
            'data' => $data,
			'artist' => $artist,
			'composer' => $composer,
			'cp' =>$cp,
			'song_name'=>$song_name
		));
	}
	/* Report CCP Video Contents
	 *
	 * */

	public function actionCCPVideodetail() {
		$model = new AdminStatisticVideoModel('searchDetail');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
		$model->setAttribute("date", $this->time);
		if ($this->cpId != 0) {
			$model->setAttribute("cp_id", $this->cpId);
		}
		$sort = null;
		if(isset($_GET['AdminStatisticVideoModel_sort'])){
			$sort = explode('.', $_GET['AdminStatisticVideoModel_sort']);
		}
		//echo "<pre>";print_r(json_decode(CJSON::encode($data->getData())));exit();
		$data = $model->searchDetail($_GET['songreport']['genre_id'],$_GET['songreport']['video_owner'], $sort);
		$this->render("videoDetail", array(
            'model' => $model,
            'cpList' => $this->cpList,
            'categoryList' => $this->categoryList,
            'time' => $this->time,
			'ccp_show' => true,
            'data'=>$data,
		));
	}
	/* Report CCP Retail
	 *
	 * */
	public function actionCCPRetail() {
		$model = new AdminStatisticSongModel('searchCCPDetail');
		$model->unsetAttributes();  // clear any default values
		$model->setAttribute("date", $this->time);
		$ccp_id = $this->ccpId;
		$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		$ccpList =  AdminCcpModel::model()->findAll();

		if($this->levelAccess <=2){
			$ccp_id = Yii::app()->request->getParam('ccp_id',null);
			$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		}
		$copyright_id = $copyright['id'];
		$copyrightType = Yii::app()->request->getParam('ccp_type',0);
		$perc = Yii::app()->request->getParam('perc',100);
		$perc = empty($perc)?100:$perc;
		$data = $model->searchCCPRetail($ccp_id,$this->time, $copyrightType);
		if($ccp_id){
			$ccp = AdminCcpModel::model()->findByPk($ccp_id);
		}else{
			$ccp = null;
			$data = null;
		}

		if (Yii::app()->request->getParam('export', false)) {
			//
			$this->layout=false;
			$fileName = "Thong_ke_noi_dung_ban_le";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_CCPRetail", array(
					'data' => $data,
					'ccp' => $ccp,
					'ccp_id' => $ccp_id,
					'ccpList' =>$ccpList,
			));
			exit();
		}
		$this->render("CCPRetail", array(
            'data' => $data,
			'ccp' => $ccp,
			'ccp_id' => $ccp_id,
			'ccpList' =>$ccpList,
			'copyrightType'=>$copyrightType,
			'perc'=>$perc
		));
	}
	/* Report Revenue Retail
	 * Doanh thu le theo ca sy
	 *
	 * */
	public function actionEvenueRetailArtist() {
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$time['from'] = $this->time['from'] . " 00:00:00";
			$time['to'] = $this->time['to'] . " 23:59:59";
		}else{
			$tt = $this->time;
			$time['from'] = $this->time . " 00:00:00";
			$time['to'] = $this->time . " 23:59:59";
		}

		$perc = Yii::app()->request->getParam('perc',100);
		$perc = empty($perc)?100:$perc;
		$artist = Yii::app()->request->getParam('artist',0);
		$composer = Yii::app()->request->getParam('composer',0);
		$cp = Yii::app()->request->getParam('cp',0);
		
		$data = AdminStatisticSongModel::model()->revenueRetailArtist($artist,$composer, $cp, $time);
		
		if (Yii::app()->request->getParam('export', false)) {
			//
			$this->layout=false;
			$fileName = "Thong_ke_noi_dung_ban_le_ca_sy";
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_revenue_retail_artist", array(
					'data' => $data,
					'artist' => $artist,
					'composer' => $composer,
					'cp' =>$cp,
					'perc'=>$perc
			));
			exit();
		}
		$this->render("RevenueRetailArtist", array(
            'data' => $data,
			'artist' => $artist,
			'composer' => $composer,
			'cp' =>$cp,
			'perc'=>$perc
		));
	}

	public function actionRevenueContent() {
		if ($this->cpId != 0) {
			$cpId = $this->cpId;
		} else {
			if (isset($_GET['songreport']['cp_id'])) {
				$cpId = $_GET['songreport']['cp_id'];
			} else {
				$cpArray = json_decode(CJSON::encode($this->cpList), true);
				$cpId = $cpArray[0]['id'];
			}
		}

		$viGenreSetting = yii::app()->params['VNGenre'];
		$QTEGenreSetting = yii::app()->params['QTEGenre'];


		$songGenre = AdminGenreModel::model()->findAll();
		$genreVi = $genreQt = $genreRtVi = $genreRtQt = array();
		//echo "<pre>";print_r(json_decode(CJSON::encode($songGenre)));exit();
		foreach ($songGenre as $genre) {
			if (in_array($genre->id, $QTEGenreSetting) || in_array($genre->parent_id, $QTEGenreSetting)){
				$genreQt[] = $genre->id;
			}else{
				$genreVi[] = $genre->id;
			}
			/* if ($genre->id == 60 || $genre->parent_id == 60 || $genre->id == 623 || $genre->parent_id == 623) {
				$genreVi[] = $genre->id;
			} else {
				$genreQt[] = $genre->id;
			} */
		}


		$rtGenre = AdminRingtoneCategoryModel::model()->findAll();
		foreach ($rtGenre as $genre2) {
			if ($genre2->id == 25 || $genre2->parent_id == 25) {
				$genreRtVi[] = $genre2->id;
			} else {
				$genreRtQt[] = $genre2->id;
			}
		}


		$genre = array(
            'song' => array(
                'vi' => $genreVi,
                'qt' => $genreQt,
		),
            'video' => array(
                'vi' => $genreVi,
                'qt' => $genreQt,
		),
            'rt' => array(
                'vi' => $genreRtVi,
                'qt' => $genreRtQt,
		),
		);

		$data = AdminUserTransactionModel::model()->getTotalRevContentByCP($cpId, $this->time, $genre);
		$cpName = AdminCpModel::model()->findByPk($cpId);


		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');
			//echo "<pre>";print_r($data);exit();

			$label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'total_play_song_vi' => Yii::t('admin', 'Lượt nghe BH Việt'),
                'total_rev_play_song_vi' => Yii::t('admin', 'DT nghe BH Việt'),
                'total_down_song_vi' => Yii::t('admin', 'Lượt tải BH Việt'),
                'total_rev_down_song_vi' => Yii::t('admin', 'DT tải BH Việt'),
                'total_play_song_qt' => Yii::t('admin', 'Lượt nghe BH QTế'),
                'total_rev_play_song_qt' => Yii::t('admin', 'DT nghe BH QTế'),
                'total_down_song_qt' => Yii::t('admin', 'Lượt tải BH QTế'),
                'total_rev_down_song_qt' => Yii::t('admin', 'DT tải BH QTế'),
                'total_play_video_vi' => Yii::t('admin', 'Lượt xem video Việt'),
                'total_rev_play_video_vi' => Yii::t('admin', 'DT xem video Việt'),
                'total_down_video_vi' => Yii::t('admin', 'Lượt tải video Việt'),
                'total_rev_down_video_vi' => Yii::t('admin', 'DT tải video Việt'),
                'total_play_video_qt' => Yii::t('admin', 'Lượt xem video QTế'),
                'total_rev_play_video_qt' => Yii::t('admin', 'DT xem video QTế'),
                'total_down_video_qt' => Yii::t('admin', 'Lượt tải video QTế'),
                'total_rev_down_video_qt' => Yii::t('admin', 'DT tải video QTế'),
                'total_trans_rt_vi' => Yii::t('admin', 'Lượt tải ringtone Việt'),
                'total_rev_rt_vi' => Yii::t('admin', 'DT tải ringtone Việt'),
                'total_trans_rt_qt' => Yii::t('admin', 'Lượt tải ringtone QTế'),
                'total_rev_rt_qt' => Yii::t('admin', 'DT tải ringtone QTế'),
			);

			$title = Yii::t('admin', 'Thống kê doanh thu CP {name} (nội dung)', array('{name}' => $cpName->name));
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}


		$this->render("revenueContent", array(
            'data' => $data,
            'cpList' => $this->cpList,
            'cpName' => $cpName,
            'cpId' => $cpId,
		));
	}

	public function actionSubscribeReport() {
		$total = AdminUserSubscribeModel::model()->getTotal();
		$userSubsModel = new AdminUserSubscribeModel('search');
		$userSubsModel->unsetAttributes();  // clear any default values
		$status = 0;

		if (isset($_GET['fillter'])) {
			switch ($_GET['fillter']['status']) {
				case 1:
					$userSubsModel->setAttribute('status', 1);
					break;
				case 2:
					$userSubsModel->setAttribute('status', "<>1");
					break;
			}
			$status = $_GET['fillter']['status'];
		}

		$this->render("subscribeReport", array(
            'total' => $total,
            'userSubsModel' => $userSubsModel,
            'status' => $status,
		));
	}

	public function actionRegister() {
		$status = 0;
		$channel = 0;
		if (isset($_GET['fillter'])) {
			$status = $_GET['fillter']['status'];
			$channel = $_GET['fillter']['channel'];
		}
		$data = AdminUserTransactionModel::model()->registerReport($this->time, $status, $channel);

		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');

			$return = array();
			foreach ($data as $item) {
				$item['total_phone_fail'] = $item['total_phone'] - $item['total_success'];
				$return[] = $item;
			}


			$label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'total_phone' => Yii::t('admin', 'Tổng số thuê bao'),
                'total' => Yii::t('admin', 'Tổng số lượt ĐK'),
                'total_success' => Yii::t('admin', 'Tổng số TB thành công'),
                'total_phone_fail' => Yii::t('admin', 'Tổng số TB thất bại'),
			);

			$title = Yii::t('admin', 'Thống kê số lượt đăng ký');
			$excelObj = new ExcelExport($return, $label, $title);
			$excelObj->export();
		}

		$this->render("register", array(
            'data' => $data,
            'status' => $status,
            'channel' => $channel,
		)
		);
	}

	public function actionUnRegister() {
		$channel = 0;
		if (isset($_GET['fillter'])) {
			$channel = $_GET['fillter']['channel'];
		}
		$data = AdminUserTransactionModel::model()->unsubReport($this->time, $channel);

		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');

			$label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'total' => Yii::t('admin', 'Tổng số'),
			);

			$title = Yii::t('admin', 'Thống kê số lượt hủy');
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}
		$this->render("unregister", array(
            'data' => $data,
            'status' => $status,
            'channel' => $channel,
		)
		);
	}

	public function actionSubscribeExt() {
		$status = 0;
		if (isset($_GET['fillter'])) {
			$status = $_GET['fillter']['status'];
		}
		$data = AdminUserTransactionModel::model()->extendsReport($this->time, $status);

		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');

			$return = array();
			foreach ($data as $item) {
				$item['total_phone_fail'] = $item['total_phone'] - $item['total_success'];
				$return[] = $item;
			}

			$label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'total_phone' => Yii::t('admin', 'Tổng số thuê bao'),
                'total' => Yii::t('admin', 'Tổng số lượt gọi'),
                'total_success' => Yii::t('admin', 'Tổng số TB thành công'),
                'total_phone_fail' => Yii::t('admin', 'Tổng số TB thất bại'),
			);

			$title = Yii::t('admin', 'Thống kê số lượt gia hạn');
			$excelObj = new ExcelExport($return, $label, $title);
			$excelObj->export();
		}

		$this->render("extends", array(
            'data' => $data,
            'status' => $status,
		)
		);
	}

	public function actionDetailByTrans() {
		$userPhone = Yii::app()->request->getParam('user_phone', null);
		if ($userPhone) {
			$userPhone = Formatter::formatPhone($userPhone);
		
			$totalRow = AdminUserTransactionModel::model()->totalTransByPhone($this->time, $userPhone);
			$page = new CPagination($totalRow);
			$page->pageSize = 30;
			$order = isset($_GET['order'])?$_GET['order']:"";
			$fieldOrder = isset($_GET['f'])?$_GET['f']:"";
			$data = AdminUserTransactionModel::model()->detailByPhone($this->time, $userPhone, $page->getLimit(), $page->getOffset(), $order, $fieldOrder);
	
			$arrayDataProvider=new CArrayDataProvider($data, array(
					'pagination'=>array(
							'pageSize'=> $page->pageSize,
					),
			));
		}
		$this->render("detailByTrans", array(
            'data' => $arrayDataProvider,
            'userPhone' => $userPhone,
            'page' => $page,
		)
		);
	}

	public function actionDetailByTime() {
		$channelList = array(
            'all' => 'Tất cả',
            'web' => 'Web',
            'wap' => 'Wap',
            'api-ios' => 'IOS Apps',
            'api-android' => 'ANDROID Apps',
            'sms' => 'SMS',
            'auto' => 'System',
            'vinaphone' => 'VinaPhone Call',
            'admin' => 'Backend',
			'WIFI'=>'WIFI',
		);
		$channel = Yii::app()->request->getParam('channel', null);
		$data = AdminUserTransactionModel::model()->detailByTransTime($this->time, $channel);

		$this->render("detailByTime", array(
            'data' => $data,
            'channelList' => $channelList,
            'channel' => $channel,
		)
		);
	}

	public function actionDetectLog() {
		$data = AdminStatisticDetectMsisdnModel::model()->getStatisticDetect($this->time);
		$this->render('detectLog', array(
            'data' => $data
		)
		);
	}

	public function actionSubscribeStatistic() {
		$packageList = array('1'=>'AM','2'=>'AM7');
		$package = Yii::app()->request->getParam('package',3);
		$data = AdminStatisticSubscribeModel::model()->getStatistic($this->time,$package);
		$this->render('subsStatistic', array(
            'data' => $data,
            'package' => $package,
            'packageList' => $packageList,
		)
		);
	}

	public function actionSubscribeExtSuccess() {

		// format time
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate . " 00:00:00", 'to' => $toDate . " 23:59:59");
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time . " 00:00:00", 'to' => $time . " 23:59:59");
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d 00:00:00", strtotime($startDay));
			$toDate = date("Y-m-d 23:59:59");
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}

		$total = AdminUserSubscribeModel::model()->getSubscribeExtIVR($this->time);
		$this->render('subscribeExtSuccess', array('total'=>$total));
	}
	/**
	 * Số thuê bao đã hủy từ tập ĐK qua IVR
	 */
	public function actionUnSubscribeExtSuccess() {

		// format time
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate . " 00:00:00", 'to' => $toDate . " 23:59:59");
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time . " 00:00:00", 'to' => $time . " 23:59:59");
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d 00:00:00", strtotime($startDay));
			$toDate = date("Y-m-d 23:59:59");
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}

		$total = AdminUserSubscribeModel::model()->getUnSubscribeExtIVR($this->time);
		$this->render('unSubscribeExtSuccess', array('total'=>$total));
	}

	public function actionSubscribePromotion() {
		$trans = Yii::app()->request->getParam('trans', 'subscribe');
		if ($trans == 'subscribe') {
			$sql = "SELECT COUNT(DISTINCT user_phone) AS total, date(created_time) AS m FROM user_transaction WHERE transaction='subscribe' AND return_code=0 AND price=0 AND note='BIGPROMOTION_2012' AND created_time>='{$this->time['from']} 00:00:00' AND created_time <= '{$this->time['to']} 23:59:59' GROUP BY m ORDER BY m DESC";
		} else if ($trans == 'unsubscribe_a') {
			$sql = "
    				SELECT COUNT(DISTINCT t1.user_phone) AS total, date(t1.created_time) AS m
    				FROM user_transaction t1
    				INNER JOIN user_transaction t2 ON t1.user_phone = t2.user_phone
    				WHERE t1.transaction='unsubscribe' AND t1.channel <> 'auto'
    				AND t1.created_time >='{$this->time['from']} 00:00:00' AND t1.created_time<='{$this->time['to']} 23:59:59'
    				AND t2.transaction='subscribe' AND t2.return_code=0 AND t2.price=0 AND t2.note='BIGPROMOTION_2012'
    				AND t2.created_time >='{$this->time['from']} 00:00:00' and t2.created_time<='{$this->time['to']} 23:59:59'
    				GROUP BY m
    				ORDER BY m DESC
    		";
		} else {
			$sql = "
    				SELECT COUNT(DISTINCT t1.user_phone) AS total, date(t1.created_time) AS m
    				FROM user_transaction t1
    				INNER JOIN user_transaction t2 ON t1.user_phone = t2.user_phone
    				WHERE t1.transaction='unsubscribe' AND t1.channel = 'auto'
    				AND t1.created_time >='{$this->time['from']} 00:00:00' AND t1.created_time<='{$this->time['to']} 23:59:59'
    				AND t2.transaction='subscribe' AND t2.return_code=0 AND t2.price=0 AND t2.note='BIGPROMOTION_2012'
    				AND t2.created_time >='{$this->time['from']} 00:00:00' and t2.created_time<='{$this->time['to']} 23:59:59'
    				GROUP BY m
    				ORDER BY m DESC
    		";
		}
		$data = Yii::app()->db->createCommand($sql)->queryAll();
		$this->render('subscribePromotion', array('data' => $data));
	}

	public function actionGiftsong() {

		$price = 0;
		if (isset($_GET['fillter'])) {
			$price = $_GET['fillter']['price'];
		}
		$data = AdminUserTransactionModel::model()->musicgiftReport($this->time, $price);

		$this->render("giftsong", array(
            'data' => $data,
            'price' => $price,
		)
		);
	}

	public function actionReportAdsClick(){
		$ads = Yii::app()->request->getParam('type','BUZZCITY');
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time['to']} tới {$this->time['from']}";
		}
		else{
			$tt = $this->time;
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time}";
		}
		$where = " and date >= '{$from}' AND date <= '{$to}'";
        if($ads == "ALL"){
            $sql = "SELECT  date,
                    SUM(click_total) AS click_total, 
                    SUM(click_3g) AS click_3g, 
                    SUM(click_unique) AS click_unique,
                    SUM(click_detect) AS click_detect,
                    SUM(click_detect_unique) AS click_detect_unique,
                    SUM(total_subs_success) AS total_subs_success,
                    SUM(total_unsubs) AS total_unsubs,
                    SUM(total_subs_ext_success) AS total_subs_ext_success,
                    SUM(total_play) AS total_play,
                    SUM(total_download) AS total_download,
                    SUM(total_subs_play) AS total_subs_play,
                    SUM(total_subs_download) AS total_subs_download,
                    SUM(total_revenue_ext) AS total_revenue_ext,
                    SUM(total_revenue_content) AS total_revenue_content,
                    SUM(total_revenue_subs) AS total_revenue_subs
                    FROM statistic_ads
                    WHERE date >= '{$from}' AND date <= '{$to}'
                    GROUP BY date
                    ORDER BY date DESC";
        }else{
            $sql = "SELECT * FROM statistic_ads WHERE ads = '{$ads}' $where ORDER BY date DESC";
        }
        $data =  Yii::app()->db->createCommand($sql)->queryAll();

        if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 1) {
			ini_set('display_errors', 'On');
			$label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'click_total' => Yii::t('admin', 'Tổng số click'),
                'click_unique' => Yii::t('admin', 'Số click ko trùng IP'),
                'click_detect' => Yii::t('admin', 'Số click Nhận diện được'),
                'click_detect_unique' => Yii::t('admin', 'Số click Nhận diện Ko trùng Ip'),
                'total_subs_success' => Yii::t('admin', 'Số đăng ký thành công'),
                'total_unsubs' => Yii::t('admin', 'Số đăng ký hủy'),
                'total_subs_ext_success' => Yii::t('admin', 'Số lượt gia hạn thành công'),
                'total_revenue_ext' => Yii::t('admin', 'Doanh thu gia hạn'),
                'total_revenue_content' => Yii::t('admin', 'Doanh thu nội dung'),
                'total_revenue_subs' => Yii::t('admin', 'Doanh thu đăng ký'),
				'total_play' => Yii::t('admin', 'Số lượt xem mất phí'),
				'total_download' => Yii::t('admin', 'Số lượt tải mất phi'),
				'total_subs_play'=>Yii::t('admin', 'Số lượt xem miễn phí'),
				'total_subs_download'=>Yii::t('admin', 'Số lượt tải miễn phí'),
			);

			$title = Yii::t('admin', 'Thống kê banner ' . $ads . " " . $tt . " ");
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}

		$this->render('reportAdsClick',array(
            'data'=>$data,
		));
	}
	public function actionReportAdsIp(){
		$ads = Yii::app()->request->getParam('type','');
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time['to']} tới {$this->time['from']}";
		}
		else{
			$tt = $this->time;
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time}";
		}

		$where = " and created_time >= '{$from}' AND created_time <= '{$to}'";
		$sql = "SELECT concat(date(created_time),user_ip) as uc, date(created_time) as m, user_ip, count(*) as total from log_ads_click where ads='{$ads}' $where group by  uc order by m desc";
		$listIP =  Yii::app()->db->createCommand($sql)->queryAll();

		if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 2) {
			$dataexport = array();
			foreach ($listIP as $item){
				if($item['total'] <= 1) continue;
				$dataexport[] = $item;
			}
			ini_set('display_errors', 'On');
			$label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'user_ip' => Yii::t('admin', 'IP'),
                'total' => Yii::t('admin', 'Số click'),
			);

			$title = Yii::t('admin', 'Danh sách IP click trùng banner '.$ads . " " . $tt . " ");
			$excelObj = new ExcelExport($dataexport, $label, $title);
			$excelObj->export();
		}

		$this->render('reportAdsIp',array(
            'listIP'=>$listIP,
		));
	}

	/* Thống kê chung tất cả các chỉ số*/
	public function actionAllindex(){
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;

		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
			$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_chung.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('export_raw',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		//them tong doanh thu nội dung CP VEGA
		//them tong doanh thu goi CP VEGA
		/* $revenueContentCP = $this->getRevenueContentCP(1, $this->time);
		$revenuePackageCP = $this->getRevenuePackageCP(1, $this->time); */
		$revenueContentCP = 0;
		$revenuePackageCP = 0;
		
		foreach ($arr_res as $key => $value){
			$arr_res[$key]['doanh_thu_noidung_cp_vega'] = number_format($revenueContentCP[$key],0,',',',');
			$arr_res[$key]['doanh_thu_package_cp_vega'] = number_format($revenuePackageCP[$key],0,',',',');
		}
		
		$this->render('allindex',array(
            'arr_res' => $arr_res,
            'arr_date' => $arr_date
		));
	}

	public function actionReportsms(){
		$sql = "select distinct phone, created_time from spam_sms_phone where group_id = 959 and status = 1 order by created_time desc";
		$phones = Yii::app()->db->createCommand($sql)->queryAll();
		if (Yii::app()->request->getParam('export', false)) {
			ini_set('display_errors', 'On');
			$label = array(
                'phone' => Yii::t('admin', 'Số điện thoại'),
                'created_time' =>Yii::t('admin', 'Thời gian'),
			);
			$title = Yii::t('admin', 'Thống kê bắn sms quảng bá app cho thuê bao Android');
			$excelObj = new ExcelExport($phones, $label, $title);
			$excelObj->export();
		}
		$this->render('reportsms',array('lists'=>$phones));
	}

	public function actionContentSp()
	{
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$time['from'] = $this->time['from'] . " 00:00:00";
			$time['to'] = $this->time['to'] . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu SP: {$this->time['from']} tới {$this->time['to']}";
		}
		else{
			$tt = $this->time;
			$time['from'] = $this->time . " 00:00:00";
			$time['to'] = $this->time . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu SP: {$this->time}";
		}
		$groupPrice = AdminLogCdrModel::model()->getContentPrice($time);
		$data = array();
		$price = array();

		if(count($groupPrice)>0){
			foreach ($groupPrice as $key => $value){
				$price[$value['transaction'].$value['price']]=$value['price'];
			}
			//$price = array_unique($price);
		}

		if(isset($_GET['dev']) && $_GET['dev']==1){
			echo '<pre>';print_r($groupPrice);
			echo '<pre>';print_r($price);
		}
		if(count($price)>0){
			$case = array();
			foreach ($price as $key => $value){
				$transaction = str_replace($value, '', $key);
				$case[]="SUM(CASE WHEN (price={$value} AND transaction='".$transaction."') THEN 1 ELSE 0 END) AS total_{$key}_{$value}";
			}
			$sql = "SELECT date(created_time) AS date,
					".implode(',', $case)."
					FROM log_cdr
					WHERE TRUE AND created_time>='{$time["from"]}' AND created_time<='{$time["to"]}' AND not(transaction ='play_album' and price <> 4000)
					GROUP BY date
					ORDER BY date ASC";
			$data = Yii::app()->db->createCommand($sql)->queryAll();
		}
		$timeFrom = date('Y-m-d', strtotime($time['from']));
		$timeTo = date('Y-m-d', strtotime($time['to']));
		$timeLabel = array();
		while ($timeFrom<=$timeTo){
			$timeLabel[] = $timeFrom;
			$timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
		}
		foreach ($timeLabel as $key => $time){
			//
			foreach ($data as $key2 => $value){
				if($value['date']==$time){
					$timeLabel[$key] = $value;
				}
			}
		}
		//sum column
		$total = array();

		foreach ($price as $key => $value){
			$total['total_'.$key.'_'.$value] = 0;
			foreach ($timeLabel as $val2){
				if(is_array($val2)){
					//$total
					$total['total_'.$key.'_'.$value] +=$val2['total_'.$key.'_'.$value];
				}
			}
		}
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			$this->layout=false;
			$fileName = 'Thong_Ke_Doanh_Thu_'.date('Y_m_d');
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render('_export_revenue_sp',array(
					'data'=>$data,
					'price'=>$price,
					'time'=>$time,
					'timeLabel'=>$timeLabel,
					'total'=>$total
			));
			exit();
		}
		$this->render('contentSp', array(
				'data'=>$data,
				'price'=>$price,
				'time'=>$time,
				'timeLabel'=>$timeLabel,
				'total'=>$total
		));
	}

	public function actionContentCp()
	{
		$year = Yii::app()->request->getParam('year',date("Y"));
		$month = Yii::app()->request->getParam('month',date("m"));
		$firstDay = date('Y-m-01 00:00:00', strtotime("$year-$month-01"));
		$lastDay = date('Y-m-t 23:59:59:00:00', strtotime("$year-$month-01"));

		$this->pageLabel = "Thống kê doanh thu CP tháng {$month}-{$year}";

		$cp = Yii::app()->request->getParam('cp',1);
		$time = array("from"=>$firstDay,"to"=>$lastDay);
		$reportContent = AdminLogCdrModel::model()->getContentCP($time,$cp);

		$this->render("contentCP",compact("reportContent","year","month"));
	}
	
	/**
	 * Doanh thu noi dung theo CP
	 * @param date('Y-m-d') $date 
	 */
	protected function getRevenueContentCP($cpId, $date)
	{
		$viGenreSetting = yii::app()->params['VNGenre'];
		$QTEGenreSetting = yii::app()->params['QTEGenre'];
		
		
		$songGenre = AdminGenreModel::model()->findAll();
		$genreVi = $genreQt = $genreRtVi = $genreRtQt = array();
		foreach ($songGenre as $genre) {
			if (in_array($genre->id, $QTEGenreSetting) || in_array($genre->parent_id, $QTEGenreSetting)){
				$genreQt[] = $genre->id;
			}else{
				$genreVi[] = $genre->id;
			}
		}
		
		
		$rtGenre = AdminRingtoneCategoryModel::model()->findAll();
		foreach ($rtGenre as $genre2) {
			if ($genre2->id == 25 || $genre2->parent_id == 25) {
				$genreRtVi[] = $genre2->id;
			} else {
				$genreRtQt[] = $genre2->id;
			}
		}
		
		$genre = array(
				'song' => array(
						'vi' => $genreVi,
						'qt' => $genreQt,
				),
				'video' => array(
						'vi' => $genreVi,
						'qt' => $genreQt,
				),
				'rt' => array(
						'vi' => $genreRtVi,
						'qt' => $genreRtQt,
				),
		);
		$dataRevenue = AdminUserTransactionModel::model()->getTotalRevContentByCP($cpId, $date, $genre);
		
		$result = array();
		$i=count($dataRevenue);
		foreach ($dataRevenue as $data){
			$i--;
			$total = (($data['total_rev_play_song_vi'] + $data['total_rev_down_song_vi'] + $data['total_rev_rt_vi'] + $data['total_rev_gift_song_vi']) * 0.3)
			+ (($data['total_rev_play_song_qt']+ $data['total_rev_down_song_qt'] + $data['total_rev_rt_qt'] + $data['total_rev_play_video_vi'] + $data['total_rev_down_video_vi'] + $data['total_rev_gift_song_qt'])*0.45)
			+ (($data['total_rev_play_video_qt'] + $data['total_rev_down_video_qt'])*0.55);
			$result[$i] = $total;
		}
		return $result;
	}
	
	/**
	 * Doanh thu goi theo CP
	 */
	protected function getRevenuePackageCP($cpId, $date)
	{
		$packageId = Yii::app()->request->getParam('package',3);
		$packageList = array(3=>'CHACHAFUN',5=>'RINGTUNEPLUS');
		
		$data = AdminUserTransactionModel::model()->getTotalRevByCP($cpId, $date,$packageId);
		$result = array();
		$i=count($data['cpTrans']);
		foreach ($data['cpTrans'] as $rev){
			$i--;
			$total5 = $total6 = $total7 = $tp =0;
			$total5 	+= $rev['download_cp']+$rev['streaming_cp'];
			$total6		+= $rev['total_download']+$rev['total_streaming'];
			if(isset($data['revPackage'][$rev['m']]))
				$total7 += $data['revPackage'][$rev['m']];
			$result[$i] = ($total5/$total6)*$total7*0.3;
		}
		return $result;
	}
        
        /* Report CCP Video Contents
	 *
	 * */
	public function actionCCPVideoDetailReport() {    
                $model = new AdminStatisticVideoModel('SearchCCPVideoDetail');
		$model->unsetAttributes();  // clear any default values
		$model->attributes = isset($_GET['songreport'])?$_GET['songreport']:'';
                                
		$model->setAttribute("date", $this->time);


		//$ccpList =  AdminCcpModel::model()->findAll();
		$ccp_id = $this->ccpId;
		$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		$ccpList =  AdminCcpModel::model()->findAll();

		if($this->levelAccess <=2){
			$ccp_id = Yii::app()->request->getParam('ccp_id',null);
			$copyright = AdminCopyrightModel::model()->findByAttributes(array('ccp'=>$ccp_id,'status'=>1));
		}
		$copyright_id = $copyright['id'];
		//$model->setAttribute("ccp_id", $copyright_id);

		$data = null;
		$copyrightType = Yii::app()->request->getParam('ccp_type',0);
		if($copyrightType==0){
			$model->setAttribute("ccp_id",$copyright_id);
		}else{
			$model->setAttribute("ccpr_id",$copyright_id);
		}
		if($ccp_id){
			if(isset($_GET['Export']) && $_GET['Export']=='Export'){
				$model->size_export_list = 65000;
			}
			$data = $model->SearchCCPVideoDetail($ccp_id,$copyrightType);
			$ccp = AdminCcpModel::model()->findByPk($ccp_id);
		}else{
			$ccp = null;
		}
                
                if(isset($ccp))
                    $this->pageLabel = Yii::t('admin', "Chi tiết video từ {from} tới {to} CCP {CCPNAME}", array('{from}' => $this->time['from'], '{to}' => $this->time['to'], '{CCPNAME}' => $ccp->name));
                else
                    $this->pageLabel = Yii::t('admin', "Chi tiết video từ {from} tới {to} CCP {CCPNAME}", array('{from}' => $this->time['from'], '{to}' => $this->time['to'], '{CCPNAME}' => ''));
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			@ini_set('max_execution_time', 3000);
			$this->layout=false;
			$fileName = "Chi_Tiet_Video_".date('d_m_Y');
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=$fileName.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$this->render("_export_CCPVideoDetailReport", array(
					'data' => $data,
					'ccp' => $ccp,
			));
			exit();
		}
		$this->render("CCPVideoDetailReport", array(
			'model'=>$model,
                        'data' => $data,
			'ccp' => $ccp,
			'ccp_id' => $ccp_id,
			'ccpList' =>$ccpList,
			'copyrightType'=>$copyrightType
		));
	}
	
	public function actionReportVegaContent()
	{
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time() - 60 * 60 * 24);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		
		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			$sql = "SELECT * from daily_reports_content where report_date='$date'";
			$results =  Yii::app()->db->createCommand($sql)->queryAll();
			foreach($results as $result){
					$arr_res[$date][$result['field_name']] = $result['field_value'];
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
				header("Content-Disposition: attachment; filename=thong_ke_noidung_bientap.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('Export_VegaReportContent',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('VegaReportContent',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
		));
	}
	
	public function actionShortlink()
	{
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time() - 60 * 60 * 24);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		//echo '<pre>';print_r($this->time);
		$shortLId = Yii::app()->request->getParam('id',0);
		$sql = "SELECT c1.*, c2.shortlink
				FROM statistic_shortlink c1
				LEFT JOIN shortlink c2 ON c1.shortlink_id=c2.id
				WHERE (c1.date BETWEEN :fromdate and :todate) and c1.shortlink_id=:lid
				ORDER BY c1.date DESC
				";
		$cm = Yii::app()->db->createCommand($sql);
		$cm->bindParam(':fromdate', $this->time['from'], PDO::PARAM_STR);
		$cm->bindParam(':todate', $this->time['to'], PDO::PARAM_STR);
		$cm->bindParam(':lid', $shortLId, PDO::PARAM_INT);
		$data = $cm->queryAll();
		//echo '<pre>';print_r($data);
		$this->render('shortlink', compact('data'));
	}
        
          public function actionDailyRegister(){
            if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
                            $createdTime = explode("-", $createdTime);
                            $fromDate = explode("/", trim($createdTime[0]));
                            $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                            $toDate = explode("/", trim($createdTime[1]));
                            $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                            $this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
                            $time = explode("/", trim($_GET['songreport']['date']));
                            $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                            $this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;

		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
			$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_chung.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('export_register_new',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('register_new',array(
                    'arr_res' => $arr_res,
                    'arr_date' => $arr_date
		));
        }
        
        public function actionDailyExtent(){
            if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
                            $createdTime = explode("-", $createdTime);
                            $fromDate = explode("/", trim($createdTime[0]));
                            $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                            $toDate = explode("/", trim($createdTime[1]));
                            $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                            $this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
                            $time = explode("/", trim($_GET['songreport']['date']));
                            $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                            $this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;

		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
			$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_chung.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('export_extent',array(
					'arr_res' => $arr_res,
					'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('extent',array(
                    'arr_res' => $arr_res,
                    'arr_date' => $arr_date
		));
        }

	public function actionReportAdsLanding(){
		$ads = Yii::app()->request->getParam('type','BUZZCITY');
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time['to']} tới {$this->time['from']}";
		}
		else{
			$tt = $this->time;
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
			$this->pageLabel = "Thống kê doanh thu: {$this->time}";
		}
		$where = " and date >= '{$from}' AND date <= '{$to}'";
		$sql = "SELECT * FROM statistic_ads WHERE ads = '{$ads}' $where ORDER BY date DESC";
		$data =  Yii::app()->db->createCommand($sql)->queryAll();
		if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 1) {
			ini_set('display_errors', 'On');
			$label = array(
				'date' => Yii::t('admin', 'Ngày'),
				'click_total' => Yii::t('admin', 'Tổng số click'),
				'click_unique' => Yii::t('admin', 'Số click ko trùng IP'),
				'click_detect' => Yii::t('admin', 'Số click Nhận diện được'),
				'click_detect_unique' => Yii::t('admin', 'Số click Nhận diện Ko trùng Ip'),
				'total_subs_success' => Yii::t('admin', 'Số đăng ký thành công'),
				'total_unsubs' => Yii::t('admin', 'Số đăng ký hủy'),
				'total_subs_ext_success' => Yii::t('admin', 'Số lượt gia hạn thành công'),
				'total_revenue_ext' => Yii::t('admin', 'Doanh thu gia hạn'),
				'total_revenue_content' => Yii::t('admin', 'Doanh thu nội dung'),
				'total_revenue_subs' => Yii::t('admin', 'Doanh thu đăng ký'),
				'total_play' => Yii::t('admin', 'Số lượt xem mất phí'),
				'total_download' => Yii::t('admin', 'Số lượt tải mất phi'),
				'total_subs_play'=>Yii::t('admin', 'Số lượt xem miễn phí'),
				'total_subs_download'=>Yii::t('admin', 'Số lượt tải miễn phí'),
			);

			$title = Yii::t('admin', 'Thống kê banner ' . $ads . " " . $tt . " ");
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}

		$this->render('reportAdsLanding',array(
			'data'=>$data,
		));
	}

	public function actionLogSmsMt(){
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = $toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
		$sum = (!isset($_GET['sum']))?0:1;

		$date = $this->time['from'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date <= $this->time['to']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
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
				header("Content-Disposition: attachment; filename=thong_ke_chung.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$this->render('log_sms_mt_expory',array(
				'arr_res' => $arr_res,
				'arr_date' => $arr_date
			));
			exit();
		}
		$this->render('log_sms_mt',array(
			'arr_res' => $arr_res,
			'arr_date' => $arr_date
		));
	}

	public function actionNewDaily(){
		if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
			$createdTime = $_GET['songreport']['date'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate , 'to' => $toDate );
			} else {
				$time = explode("/", trim($_GET['songreport']['date']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time , 'to' => $time);
			}
		} else {
			$fromDate = date('Y-m-d', time()-7*24*60*60);
			$toDate = date('Y-m-d', time()-24*60*60);
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}

		$sum = (!isset($_GET['sum']))?0:1;

		$date = $this->time['to'];
		$arr_res = $arr_date = array();
		$count_date = 0;
		while($date >= $this->time['from']){
			if(!$sum)
				$arr_res[$count_date] = array();
			$sql = "SELECT * from daily_reports where report_date='$date'";
			$results =  Yii::app()->db->createCommand($sql)->queryAll();
			foreach($results as $result){
				if(!$sum){
					$arr_res[$count_date][$result['field_name']] = $result['field_value'];
					$arr_res[$count_date]['date_time'] = $date;
				}
				else
					$arr_res[0][$result['field_name']] += $result['field_value'];
			}
			$arr_date[] = $date;
			$date = date('Y-m-d',strtotime("-1 day",strtotime("$date")));
			$count_date++;
		}
		//export
		if(isset($_GET['Export']) && $_GET['Export']=='Export'){
			$this->layout=false;
			if(isset($_GET['dev']) && $_GET['dev']==1){
				//
			}else{
				header('Content-type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=thong_ke_ngay.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			$log_detect = AdminStatisticDetectMsisdnModel::model()->getStatisticDetect($this->time);

			$this->render('_export_raw_dailyreport',array(
				'arr_res' 		=> $arr_res,
				'arr_date' 		=> $arr_date,
				'log_detect'	=> $log_detect,
			));
			exit();
		}
		$log_detect = AdminStatisticDetectMsisdnModel::model()->getStatisticDetect($this->time);
		$this->render('new_daily_report',array(
			'arr_res' 		=> $arr_res,
			'arr_date' 		=> $arr_date,
			'log_detect'	=> $log_detect,
		));
	}

	public function actionPackageOffline(){
		$package_offline_name = Yii::app()->request->getParam('type','');
		$mes = '';
		$package_offline_obj = PackageOfflineModel::model()->findByAttributes(array('code' => $package_offline_name));
		if(empty($package_offline_obj)){
			$mes = 'Vui lòng chọn cú pháp';
			$this->render('reportPackageOffline',array(
				'mes'=>$mes,
			));
		}
		if(in_array("PackageOfflineRole",Yii::app()->user->roles)) {
			$user_list = explode(";", $package_offline_obj->admin_user);
			if(!in_array(Yii::app()->user->username, $user_list)){
				$mes = 'Bạn không có quyền xem cú pháp này!';
				$this->render('reportPackageOffline',array(
					'mes'=>$mes,
				));
			}
		}
		if(is_array($this->time)){
			$tt = $this->time['from'] . " - " . $this->time['to'];
			$from = $this->time['from'] . " 00:00:00";
			$to = $this->time['to'] . " 23:59:59";
			$this->pageLabel = "Thống kê cú pháp sms offline từ: {$this->time['to']} tới {$this->time['from']}";
		}
		else{
			$tt = $this->time;
			$from = $this->time . " 00:00:00";
			$to = $this->time . " 23:59:59";
			$this->pageLabel = "Thống kê cú pháp sms offline: {$this->time}";
		}
		$where = " and date >= '{$from}' AND date <= '{$to}'";
		$sql = "SELECT * FROM statistic_package_offline WHERE package_offline_name = '{$package_offline_name}' $where ORDER BY date DESC";
		$data =  Yii::app()->db->createCommand($sql)->queryAll();


		if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 1) {
			ini_set('display_errors', 'On');
			$label = array(
				'date' => Yii::t('admin', 'Ngày'),
				'total_subs' => Yii::t('admin', 'Tổng số ĐK'),
				'total_subs_unsuccess' => Yii::t('admin', 'Tổng số ĐK thành công'),
				'total_subs_success' => Yii::t('admin', 'Tổng số ĐK không thành công'),
				'total_unsubs' => Yii::t('admin', 'Tổng số thuê bao hủy'),
				'total_accumulated' => Yii::t('admin', 'Tổng số thuê bao lũy kế'),
				'total_ext' => Yii::t('admin', 'Tổng số thuê bao gia hạn'),
				'total_ext_success' => Yii::t('admin', 'Tổng số thuê bao gia hạn thành công'),
				'total_ext_unsuccess' => Yii::t('admin', 'Tổng số thuê bao gia hạn không'),
				'total_revenue' => Yii::t('admin', 'Tổng doanh thu'),
			);

			$title = Yii::t('admin', 'Thống kê cú pháp ' . $package_offline_name . " " . $tt . " ");
			$excelObj = new ExcelExport($data, $label, $title);
			$excelObj->export();
		}

		$this->render('reportPackageOffline',array(
			'data'=>$data, 'mes'=>$mes
		));
	}

	public function actionExportUser(){
        $package_id = (isset($_GET['package_id']))? $_GET['package_id'] : 0;
        if(isset($_GET['Export']) && $_GET['Export']=='Export'){
            if($package_id == 0){
                $sql = "SELECT user_phone FROM user_subscribe WHERE status = 1";
                $fileName = 'amusic_user_active_'.date("YmdHis").'.txt';
            }else{
                $sql = "SELECT user_phone FROM user_subscribe WHERE package_id =  '{$package_id}' AND status = 1";
                $fileName = 'amusic_user_active_package_'. $package_id .'_'.date("YmdHis").'.txt';
            }
            $dataReport =  Yii::app()->db->createCommand($sql)->queryAll();
            $line ='';
            foreach ($dataReport as $one) {
                $line .= $one['user_phone'] . "\r\n";
            }
            ob_start();
            header("Content-type: text/plain");
            header("Content-Disposition: attachment; filename=".$fileName);
            echo $line;
            Yii::app()->end();
        }
        $package = PackageModel::model()->findAll();
        $this->render('export_user',array(
            'package'=>$package,
            'package_id'=>$package_id
        ));
    }

    public function actionCopyrightCCP() {
        if (is_array($this->time)) {
            $tt = $this->time['from'] . " - " . $this->time['to'];
            $time['from'] = $this->time['from'] . " 00:00:00";
            $time['to'] = $this->time['to'] . " 23:59:59";
        } else {
            $tt = $this->time;
            $time['from'] = $this->time . " 00:00:00";
            $time['to'] = $this->time . " 23:59:59";
        }
        $model = new AdminStatisticSongModel('searchCopyrightCCP');
        $model->unsetAttributes();  // clear any default values
        $model->setAttribute("date", $time);

        $model->fillterType = Yii::app()->request->getParam('fillter_time', 1);
        $copyrightType = Yii::app()->request->getParam('ccp_type', 0);

        $data = $model->searchCopyrightCCP($time, $copyrightType);
        if (Yii::app()->request->getParam('export', false)) {
            $this->layout = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'srbac.css' => false,
            );
            $fileName = "Thong_ke_doanh_thu_ban_quyen";
            header('Content-type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$fileName.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->render("_export_copyrightCCP", array(
                'data' => $data
            ));
            exit();
        }
        $this->render("copyrightCCP", array(
            'data' => $data,
            'copyrightType' => $copyrightType
        ));
    }

}