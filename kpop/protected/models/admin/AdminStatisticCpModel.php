<?php

Yii::import('application.models.db.StatisticCpModel');

class AdminStatisticCpModel extends StatisticCpModel
{
    var $className = __CLASS__;
    var $sum_total;
    var $sum_played_count;
    var $sum_downloaded_count;
    
    var $sum_revenue;
    
    var $period;
    var $package_id;
    
	public function getCpRevenueRecords($period=0)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('date',$this->date,true);
        
        switch ($period){
            case ReportController::PERIOD_WEEK:
                $criteria->select = "CONCAT(WEEK(date),'_',YEAR(date)) as period, SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
                $criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
                break;
            case ReportController::PERIOD_MONTH:
                $criteria->select = "CONCAT(month(date),'/',year(date)) as period, SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
                $criteria->group = "CONCAT(month(date),'/',year(date))";
                break;
            case ReportController::PERIOD_DAY:
            default:
                $criteria->select = "date as period,SUM(revenue) AS sum_revenue, SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count";
                $criteria->group = "date";
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
    
    public function getSummarizeByPackagesArray(){
        
    }
    
    public function getCpRevenueByPackagesReport($period=0,$packages=array()){
		$criteria=new CDbCriteria;
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('date',$this->date,true);
        $criteria->order = "date,package_id";
        switch ($period){
            case 1:
                $criteria->select = "CONCAT(WEEK(date),'_',YEAR(date)) as period, SUM(revenue) AS sum_revenue, package_id";
                $criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
                break;
            case 2:
                $criteria->select = "CONCAT(month(date),'/',year(date)) as period, SUM(revenue) AS sum_revenue, package_id";
                $criteria->group = "CONCAT(month(date),'/',year(date))";
                break;
            case 0:
            default:
                $criteria->select = "date as period,SUM(revenue) AS sum_revenue, package_id";
                $criteria->group = "date";
        }        
        $criteria->group .= ",package_id";
        $results = self::model()->findAll($criteria);
        
        $output = "";
        $last_result = false;
        $current_packages = $packages;
        $summarize = $packages;
        
        foreach ($results as $result){
            if ($last_result!=false&&$last_result->period != $result->period){
                $output .= $last_result->period.";".implode(";",$current_packages).";".array_sum($current_packages)."\\n";
                $current_packages = $packages;
            }
            $current_packages[$result->package_id] = $result->sum_revenue;
            $summarize[$result->package_id] += $result->sum_revenue;
            $last_result = $result;
        }
        if ($last_result)
            $output .= $last_result->period.";".implode(";",$current_packages).";".array_sum($current_packages)."\\n";
       
        return array("content"=>$output,"summarize"=>$summarize);
    }
    
    public static function getCpRevenueReport($dateFrom,$dateTo,$cpId=0,$period = 0){ 
        $criteria = new CDbCriteria();
        
        $criteria->condition = "date >= :dateFrom AND date <= :dateTo";
        if ($cpId&&$cpId!=0){
            $criteria->condition .= " AND cp_id = :cpId";
        }
        $criteria->params = array("dateFrom"=>$dateFrom,"dateTo"=>$dateTo,"cpId"=>$cpId);
        
        switch ($period){
            case 1:
                $criteria->select = "CONCAT(WEEK(date),'_',YEAR(date)) as period, SUM(revenue) AS sum_revenue";
                $criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
                break;
            case 2:
                $criteria->select = "STR_TO_DATE(CONCAT(YEARWEEK(date),' Monday'), '%X%V %W') as period, SUM(revenue) AS sum_revenue";
                $criteria->group = "CONCAT(month(date),'/',year(date))";
                break;
            case 0:
            default:
                $criteria->select = "date as period,SUM(revenue) AS sum_revenue";
                $criteria->group = "date";
        }
        $results = self::model()->findAll($criteria);
        
        $output = "";
        foreach ($results as $result){
            $output .= $result->period.";".$result->sum_revenue."\\n";
        }
        
        if ($output!="")
            return $output;
        else 
            return ";";
    }
    
    public static function getAllCpContentReport($dateFrom,$dateTo,$cpId=0){
        $criteria = new CDbCriteria();
        $criteria->select = "date,SUM(played_count) as sum_played_count, SUM(downloaded_count) as sum_downloaded_count, 
                            SUM(played_count+downloaded_count) as sum_total";
        $criteria->condition = "date >= :dateFrom AND date <= :dateTo";
        $criteria->params = array("dateFrom"=>$dateFrom,"dateTo"=>$dateTo);
        
        if ($cpId!=0){
            $criteria->condition .= " AND cp_id = :cpId";
            $criteria->params[] = $cpId;
        }
        
        $criteria->order = "date ASC";
        $criteria->group = "date";
        
        $model = self::model();
        $model->sum_downloaded_count = 0;
        $results  = $model->findAll($criteria);     
        
        $output = "";
        foreach ($results as $result){
            $output .= $result->date. ";". $result->sum_played_count.";". $result->sum_downloaded_count.";". $result->sum_total."\\n";
        }
        
        
        if ($output=="")
            $output = ";;;";
        return $output;
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}