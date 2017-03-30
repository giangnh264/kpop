<?php

/**
 * This is the model class for table "push_notif_setting".
 *
 * The followings are the available columns in table 'push_notif_setting':
 * @property integer $id
 * @property string $device_os
 * @property string $message
 * @property integer $type
 * @property string $data
 * @property string $timesend
 * @property integer $group
 * @property integer $status
 * @property string $object_type
 * @property integer $artist_id
 */
class BasePushNotifSettingModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PushNotifSetting the static model class
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
		return 'push_notif_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, group, status, artist_id', 'numerical', 'integerOnly'=>true),
			array('device_os', 'length', 'max'=>50),
			array('message, data', 'length', 'max'=>255),
			array('object_type', 'length', 'max'=>10),
			array('timesend', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_os, message, type, data, timesend, group, status, object_type, artist_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('device_os',$this->device_os,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('timesend',$this->timesend,true);
		$criteria->compare('group',$this->group);
		$criteria->compare('status',$this->status);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('artist_id',$this->artist_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}