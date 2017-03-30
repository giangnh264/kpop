<?php
class LogApiVinaphoneModel extends BaseLogApiVinaphoneModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogApiVinaphoneModel the static model class
	 */
	protected $_dkhuy = false;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('id',$this->id);
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('msisdn_a',$this->msisdn_a,false);
		$criteria->compare('msisdn_b',$this->msisdn_b,true);
		$criteria->compare('promotion',$this->promotion);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('clientip',$this->clientip,true);
		$criteria->compare('channel',$this->channel,true);
		//$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('error_id',$this->error_id,true);
		$criteria->compare('error_desc',$this->error_desc,true);
		if (!empty($this->created_datetime)) {
			$criteria->addBetweenCondition('created_datetime', $this->created_datetime['from'], $this->created_datetime['to']);
		}
		if($this->_dkhuy){
			$criteria->addCondition("type='subscribe' OR type='unsubscribe'");
		}
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort' => array('defaultOrder' => 'id DESC'),
				'pagination'=>array(
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
				),
		));
	}

}