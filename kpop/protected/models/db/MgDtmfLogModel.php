<?php

class MgDtmfLogModel extends BaseMgDtmfLogModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MgDtmfLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getMaxLine()
	{
		$c =  new CDbCriteria();
		$c->condition = "DATE(created_time) = DATE(NOW())";
		$c->order = "id DESC";
		$row = self::model()->find($c);
		if(!empty($row))
		{
			return $row->line_file;
		}
		return 0;
	}

	public function getLoginDayByPhone($phone)
	{
		$c = new CDbCriteria();
		$c->condition = "DATE(created_time) = DATE(NOW()) AND msisdn=:PHONE";
		$c->params = array(":PHONE"=>$phone);
		return self::model()->count($c);
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('id',$this->id,true);
		$criteria->compare('start_call',$this->start_call,true);
		$criteria->compare('end_call',$this->end_call,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('first_key',$this->first_key,true);
		$criteria->compare('activity_log',$this->activity_log,true);
		$criteria->compare('total_time',$this->total_time,true);
		$criteria->compare('line_file',$this->line_file);
		//$criteria->compare('created_time',$this->created_time,true);
		if(!empty($this->created_time)){
			$criteria->addBetweenCondition('created_time', $this->created_time[0],$this->created_time[1]);
		}
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
				),
		));
	}
}