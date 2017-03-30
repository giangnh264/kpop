<?php

/**
 * This is the model class for table "device_subscribe".
 *
 * The followings are the available columns in table 'device_subscribe':
 * @property integer $id
 * @property string $regId
 * @property string $deviceId
 * @property string $os
 * @property string $phone
 * @property string $created_time
 * @property string $update_time
 * @property integer $status
 */
class BaseDeviceSubscribeModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DeviceSubscribe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device_subscribe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('regId, deviceId', 'length', 'max'=>255),
			array('os', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>15),
			array('created_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, regId, deviceId, os, phone, created_time, update_time, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return Common::loadMessages("db");
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('regId',$this->regId,true);
		$criteria->compare('deviceId',$this->deviceId,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}