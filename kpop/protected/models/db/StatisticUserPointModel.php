<?php

class StatisticUserPointModel extends BaseStatisticUserPointModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticUserPoint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function findUserByWeek($week){
	    $type = Yii::app()->params['ctkm']['type_name'];
		$cr = new CDbCriteria();
		$cr->condition = 'week = :WEEK AND type = :TYPE' ;
		$cr->params = array(':WEEK'=>$week, ':TYPE'=>$type);
		$cr->limit = 2;
		$cr->order = 'point DESC';
		return self::model()->findAll($cr);
	}

	public function getListWeek(){
		$sql = "SELECT week FROM statistic_user_point GROUP BY week";
		$command = Yii::app()->db->createCommand($sql);
		$data = $command->queryAll();
		return $data;
	}

}