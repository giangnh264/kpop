<?php

class ToolsSettingGetMsisdnModel extends BaseToolsSettingGetMsisdnModel
{
	const START = 'Start';
	const PROCESSING = 'Processing';
	const COMPLETED = 'Completed';
	/**
	 * Returns the static model of the specified AR class.
	 * @return ToolsSettingGetMsisdn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function scopes()
	{
		return array(
			'Start'=>array("condition" => "t.status = " . self::START),	
			'Processing'=>array("condition" => "t.status = " . self::PROCESSING),
			'Completed'=>array("condition" => "t.status = " . self::COMPLETED),
		);
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('status',$this->status,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
				),
		));
	}
}