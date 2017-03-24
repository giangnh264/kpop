<?php

class ReportController extends Controller
{
    const PERIOD_DAY    =    0;
    const PERIOD_WEEK   =    1;
    const PERIOD_MONTH  =    2;
    
    const CONTENT_SONG = 0;
    const CONTENT_CLIP = 1;
    const CONTENT_RTONE = 2;
    
    public static $period = array(self::PERIOD_DAY=>"ngày",self::PERIOD_WEEK=>"tuần",self::PERIOD_MONTH=>"tháng");
    public static $colors = array("#2F1BE0","#E0461B","#74E01B","#E08B1B","#1BB2E0","#B91BE0","#E0E01B","#E0E01B");
    public static $content = array(self::CONTENT_SONG=>"Bài hát",self::CONTENT_CLIP=>"Video");//,self::CONTENT_RTONE=>"Nhạc chuông");
    
    const GLOBAL_ADMIN = 0;
    
    
    
    public function init()
	{
        parent::init();
        $this->pageTitle = Yii::t('admin', "Thống kê") ;
        /*
        $this->slidebar=array(
            array('label'=>Yii::t('admin', 'Tổng hợp'), 'url'=>array('report/index')),
			array('label'=>Yii::t('admin', 'Thống kê doanh thu'), 'url'=>array('report/revenue')),
			array('label'=>Yii::t('admin', 'Thống kê nội dung'), 'url'=>array('report/content')),    
			array('label'=>Yii::t('admin', 'Thống kê thuê bao'), 'url'=>array('report/subscriber')),    
        );
        */                
	}    
    
    public function actionIndex(){
        $this->actionOverview();
    }
	public function actionContent()
	{
        if (!isset($_GET['period']))
            $_GET['period']  = self::PERIOD_DAY;
        
        if (!isset($_GET['content_type']))
            $_GET['content_type']  = self::CONTENT_SONG;
        
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
        switch ($_GET['content_type']){
            case self::CONTENT_CLIP:
                $model = new AdminStatisticVideoModel('search');
                break;
            case self::CONTENT_RTONE:
                $model = new AdminStatisticRingtoneModel('search'); 
                break;
            case self::CONTENT_SONG:
            default:
                $model=new AdminStatisticSongModel('search');                
        }
		$model->unsetAttributes();  // clear any default values
        
		if(isset($_GET[$model->className])){
			$model->attributes=$_GET[$model->className];
            $date = trim($_GET[$model->className]['date']);
            $splited = explode("-",$date);
            if (count($splited)>1)
            {
                $fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
                $toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');;
            //    $model->setAttribute("date", array(0=>$fromDate,1=>$toDate));
              //  $model->date = ">= $fromDate and <= $toDate";
                $model->date = array($fromDate,$toDate);
              //  echo $model->date;
            }
            else{
                if ($date!="")
                    $model->date = DateTime::createFromFormat('m/j/Y', $date)->format('Y-m-j');
            }                     
        }
        if ($this->cpId==0){
            $cp = AdminCpModel::model()->findAll();
            $cpList = CMap::mergeArray(
                        array(''=> Yii::t('admin',"Tất cả")),
                        CHtml::listData($cp, 'id', 'name')
                    );
        }
         else{
            $cpList = CHtml::listData(AdminCpModel::model()->findAllByPk($this->cpId), 'id', 'name');
        }        
        
        $genreList = AdminGenreModel::model()->gettreelist(2);
        
        $result = $model->getContentReport($_GET['period']);
        $graph = implode("*",array(Yii::t('admin',"Lượt xem").",".self::$colors[0],
                       Yii::t('admin',"Lượt tải").",".self::$colors[1],
                       Yii::t('admin',"Tổng cộng").",".self::$colors[2],
                    ));

		$this->render('content',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
            'cpList'=>$cpList,
            'genreList'=>$genreList,
            'contentReport'=> array("data"=> $result["content"],"graphs"=>$graph),  
            'total'=>$result["total"],
		));
	}

	public function actionOverview()
	{
        //$totalSong = AdminSongModel::getTotalSongByCp($this->cpId);
        $now = new DateTime();
        $fromDate = $now->format('Y-m-j');
        $now->sub(new DateInterval('P6D'));
        $toDate = $now->format('Y-m-j');
        
        $contentReport = AdminStatisticCpModel::getAllCpContentReport($fromDate, $toDate,$this->cpId);
//        $this->cpId = 0;
 
        if ($this->cpId == self::GLOBAL_ADMIN){ // IS GLOBAL ADMIN
            $revenueReport = AdminStatisticRevenueModel::getSumRevenueReport($fromDate, $toDate);
            $subscriberReport = AdminStatisticSubscribeModel::getActiveSubscriberReport($fromDate, $toDate,self::GLOBAL_ADMIN);
        }
        else{                // IS CONTENT PROVIDER
            $revenueReport = ";"; // TO DO
            $revenueReport = AdminStatisticCpModel::getCpRevenueReport($fromDate, $toDate, $this->cpId);
            $subscriberReport = "";
        }
        
        $params = array(
            "contentLast7DaysReport"=>array("data"=>$contentReport,"graphs"=>"Lượt xem,#2F1BE0*Lượt tải,#E0461B*Tổng cộng,#74E01B"),
            "revenueLast7DaysReport"=>array("data"=>$revenueReport,"graphs"=>"Doanh thu,#2F1BE0"),
            "subscriberLast7DaysReport"=>array("data"=>$subscriberReport,"graphs"=>"Thuê bao,#2F1BE0"),
        );
		$this->render('overview', $params);
	}

	public function actionRevenue()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminStatisticCpModel('search');
		$model->unsetAttributes();  // clear any default values
        
		if(isset($_GET['AdminStatisticCpModel'])){
			$model->attributes=$_GET['AdminStatisticCpModel'];
            $date = trim($_GET['AdminStatisticCpModel']['date']);
            $splited = explode("-",$date);
            if (count($splited)>1)
            {
                $fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
                $toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');;
                $model->date = ">= $fromDate and <= $toDate";
            }
            else{
                if ($date!="")
                    $model->date = DateTime::createFromFormat('m/j/Y', $date)->format('Y-m-j');
            }            
        }
        
        if (!isset($_GET['period']))
            $_GET['period']  = self::PERIOD_DAY;
        
        if ($this->cpId==0){
            $cp = AdminCpModel::model()->findAll();
            $cpList = CMap::mergeArray(
                        array(''=> Yii::t('admin',"Tất cả")),
                        CHtml::listData($cp, 'id', 'name')
                    );
        }
         else{
            $cpList = CHtml::listData(AdminCpModel::model()->findAllByPk($this->cpId), 'id', 'name');
        }
        
        $packages = AdminPackageModel::model()->findAll();
        $i = 0;
        $graph = "";
        
        $current_packages = array();
        foreach ($packages as $package){
            $graph .= $package->name.",".ReportController::$colors[$i]."*";
            $current_packages[$package->id] = 0;
            $i = $i + 1;
        }
        $graph .= Yii::t('admin',"Tất cả").",".ReportController::$colors[$i];
        $result = $model->getCpRevenueByPackagesReport($_GET['period'],$current_packages);
        
        $display_packages = array();
        $total_sum = array_sum($result["summarize"]);
        foreach($packages as $package){
            $display_packages[] = array(
                    "format"=>"Gói cước {name} (%Tổng cộng): {value} VNĐ ({percent})",
                    "{name}" => $package->name,
                    "{value}" => number_format($result["summarize"][$package->id], 0,",","."),
                    "{percent}"=>number_format(($total_sum)?$result["summarize"][$package->id]*100/$total_sum:0,0).'%',
                );
        }
        $display_packages[] = array(
                "format" => Yii::t("admin","Tổng cộng {value} VNĐ"),
                "{value}" => number_format($total_sum, 0,",","."),
            );
        
		$this->render('revenue',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
            'cpList'=>$cpList,
            'revenueReport'=> array("data"=> $result["content"],"graphs"=>$graph),
            'packages'=>$display_packages,
		));
	}

	public function actionSubscriber()
	{
        if (!isset($_GET['period']))
            $_GET['period']  = self::PERIOD_DAY;
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminStatisticSubscribeModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminStatisticSubscribeModel'])){
			$model->attributes=$_GET['AdminStatisticSubscribeModel'];
            $date = trim($_GET['AdminStatisticSubscribeModel']['date']);
            $splited = explode("-",$date);
            if (count($splited)>1)
            {
                $fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
                $toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');;
            //    $model->setAttribute("date", array(0=>$fromDate,1=>$toDate));
              //  $model->date = ">= $fromDate and <= $toDate";
                $model->date = array($fromDate,$toDate);
              //  echo $model->date;
            }
            else{
                if ($date!="")
                    $model->date = DateTime::createFromFormat('m/j/Y', $date)->format('Y-m-j');
            }               
        }
        
        $packages = AdminPackageModel::model()->findAll();
        $i = 0;
        $graph = "";
        
        $current_packages = array();
        foreach ($packages as $package){
            $graph .= $package->name.",".ReportController::$colors[$i]."*";
            $current_packages[$package->id] = 0;
            $i = $i + 1;
        }
        $graph .= Yii::t('admin',"Tất cả").",".ReportController::$colors[$i];
        $result = $model->getSubsriberReport($current_packages,$_GET['period']);
        

		$this->render('subscriber',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
            'subscriberReport'=> array("data"=> $result['content'],"graphs"=>$graph),
		));        
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}