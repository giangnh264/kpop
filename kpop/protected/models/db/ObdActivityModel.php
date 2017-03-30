<?php

class ObdActivityModel extends BaseObdActivityModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ObdActivity the static model class
	 */
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('group_id',$this->group_id,false);
		$criteria->compare('response_key',$this->response_key,true);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('error_msg',$this->error_msg,true);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array('defaultOrder' => 'created_time desc '),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}