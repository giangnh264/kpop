<?php

Yii::import('application.models.db.StatisticRevenueModel');

class AdminStatisticRevenueModel extends StatisticRevenueModel
{
    var $className = __CLASS__;
    public $sum_revenue;

    public static function getSumRevenueReport($dateFrom,$dateTo){
        $criteria=new CDbCriteria;
        $criteria->select = "date,song_revenue + video_revenue + ringtone_revenue + rbt_revenue + subscribe_revenue + subscribe_ext_revenue AS sum_revenue";
        $criteria->condition = "date >= :dateFrom AND date <= :dateTo";
        $criteria->params = array("dateFrom"=>$dateFrom,"dateTo"=>$dateTo);
        $criteria->order = "date ASC";
        $results  = self::model()->findAll($criteria);
        
        $output = "";
        foreach ($results as $result){
            $output .= $result->date. ";". $result->sum_revenue."\\n";
        }
        
        if ($output=="")
            $output = ";";
        
        return $output;
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('date',$this->date,true);
		$criteria->compare('song_revenue',$this->song_revenue,true);
		$criteria->compare('song_play_revenue',$this->song_play_revenue,true);
		$criteria->compare('song_download_revenue',$this->song_download_revenue,true);
		$criteria->compare('video_revenue',$this->video_revenue,true);
		$criteria->compare('video_play_revenue',$this->video_play_revenue,true);
		$criteria->compare('video_download_revenue',$this->video_download_revenue,true);
		$criteria->compare('ringtone_revenue',$this->ringtone_revenue,true);
		$criteria->compare('rbt_revenue',$this->rbt_revenue,true);
		$criteria->compare('album_revenue',$this->album_revenue,true);
		$criteria->compare('subscribe_revenue',$this->subscribe_revenue,true);
		$criteria->compare('subscribe_ext_revenue',$this->subscribe_ext_revenue,true);
		$criteria->compare('total_revenue',$this->total_revenue,true);
		
		if(!empty($this->date)){
                    if(is_array($this->date))
			$criteria->addBetweenCondition('date',$this->date['from'],$this->date['to']);
                    else
                        $criteria->compare('date',$this->date,true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'date DESC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}