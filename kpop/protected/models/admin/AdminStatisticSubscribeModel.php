<?php

Yii::import('application.models.db.StatisticSubscribeModel');

class AdminStatisticSubscribeModel extends StatisticSubscribeModel
{
    var $className = __CLASS__;
    var $total_active_count;

    var $sum_subscribe_count;
    var $sum_subscribe_ext_count;
    var $sum_expired_count;
    var $sum_unsubscribe_count;

    var $avg_active_count;
    var $period;

    public function getSubsriberReport($packages,$period = ReportController::PERIOD_DAY){
  		$criteria=new CDbCriteria;
        if (is_array($this->date)){
            $criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
        }
        else
            $criteria->compare('date',$this->date,true);

        $criteria->order = "period,package_id";
        $criteria->join = "INNER JOIN package ON t.package_id = package.id";
        switch ($period){
            case ReportController::PERIOD_WEEK:
                $criteria->select = "package_id,CONCAT(WEEK(date),'_',YEAR(date)) as period, AVG(active_count) AS avg_active_count";
                $criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
                break;
            case ReportController::PERIOD_MONTH:
                $criteria->select = "package_id,CONCAT(month(date),'/',year(date)) as period, AVG(active_count) AS avg_active_count";
                $criteria->group = "CONCAT(month(date),'/',year(date))";
                break;
            case ReportController::PERIOD_DAY:
            default:
                $criteria->select = "package_id,date as period, AVG(active_count) AS avg_active_count";
                $criteria->group = "date";
        }
        $criteria->group .= ",package_id";
        $results = self::model()->findAll($criteria);

        $output = "";
        $last_result = false;
        $current_packages = $packages;
        //$summarize = $packages;

        foreach ($results as $result){
            if ($last_result!=false&&$last_result->period != $result->period){
                $output .= $last_result->period.";".implode(";",$current_packages).";".array_sum($current_packages)."\\n";
                $current_packages = $packages;
            }
            $current_packages[$result->package_id] = number_format($result->avg_active_count,1,".","");
           // $summarize[$result->package_id] += $result->avg_active_count;
            $last_result = $result;
        }
        if ($last_result)
            $output .= $last_result->period.";".implode(";",$current_packages).";".array_sum($current_packages)."\\n";

        if ($output=="")
            for($i=0;$i<count($packages)+1;$i++)
                $output .= ";";
        return array("content"=>$output);
    }

    public function getSubscriberRecords($period = ReportController::PERIOD_DAY)
	{
		$criteria=new CDbCriteria;
        if (is_array($this->date)){
            $criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
        }
        else
            $criteria->compare('date',$this->date,true);

     switch ($period){
            case ReportController::PERIOD_WEEK:
                $criteria->select = "CONCAT(WEEK(date),'_',YEAR(date)) as period, SUM(subscribe_count) AS sum_subscribe_count, SUM(subscribe_ext_count) AS sum_subscribe_ext_count, SUM(expired_count) AS sum_expired_count, SUM(unsubscribe_count) AS sum_unsubscribe_count";
                $criteria->group= "CONCAT('".Yii::t('admin',"Tuần ")."',WEEK(date),'_',YEAR(date))";
                break;
            case ReportController::PERIOD_MONTH:
                $criteria->select = "CONCAT(month(date),'/',year(date)) as period, SUM(subscribe_count) AS sum_subscribe_count, SUM(subscribe_ext_count) AS sum_subscribe_ext_count, SUM(expired_count) AS sum_expired_count, SUM(unsubscribe_count) AS sum_unsubscribe_count";
                $criteria->group = "CONCAT(month(date),'/',year(date))";
                break;
            case ReportController::PERIOD_DAY:
            default:
                $criteria->select = "date as period, SUM(subscribe_count) AS sum_subscribe_count, SUM(subscribe_ext_count) AS sum_subscribe_ext_count, SUM(expired_count) AS sum_expired_count, SUM(unsubscribe_count) AS sum_unsubscribe_count";
                $criteria->group = "date";
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}

    public static function getActiveSubscriberReport($dateFrom,$dateTo,$packageId=0){
        $criteria = new CDbCriteria();
        $criteria->select = "date, SUM(active_count) as total_active_count";
        if ($packageId&&$packageId!=0){
            $criteria->condition = "package_id = :packageId";
            $criteria->params = array("packageId"=>$packageId);
        }

       $criteria->addBetweenCondition('date', $dateFrom, $dateTo);
       $criteria->group = "date";
       $results = self::model()->findAll($criteria);

       $output = "";
       foreach ($results as $result){
           $output .= $result->date.";".$result->total_active_count."\\n";
       }

       if ($output!="")
           return $output;
       else
           return ";";

    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getStatistic($time,$package = 3)
    {
    	$sql = "SELECT *
    			FROM statistic_subscribe
    			WHERE date >= '{$time['from']}' AND date <= '{$time['to']}' AND package_id = '{$package}'
    			ORDER BY date DESC";
    	return Yii::app()->db->createCommand($sql)->queryAll();
    }
    public function getTotalStatisticSubscribeByTimeRange($date = null, $package_id = 3)
    {
        $where = "TRUE ";
        if(is_array($date)){
                $where .= " AND date(date) >= '".$date['from']. "' AND date(date) <= '".$date['to']."' ";
        }else{
                $where .= " AND date(date) = '" .$date ."' ";
        }
        if($package_id)
            $where .= " AND package_id = ".$package_id;
        $finalWhere = " WHERE $where ";
        $sql = "SELECT date(date) as date, total_user_use_service
                FROM statistic_subscribe 
                $finalWhere
                ORDER BY date(date) DESC";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }
}