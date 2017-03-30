<?php

/**
 * This is the model class for table "device_2".
 *
 * The followings are the available columns in table 'device_2':
 * @property string $id
 * @property string $device_id
 * @property string $user_agent
 * @property string $model
 * @property string $brand
 * @property string $marketing_name
 * @property string $description
 * @property string $os
 * @property string $resolution
 * @property string $is_tablet
 * @property string $is_smarttv
 * @property string $streaming_preferred_protocol
 * @property string $fall_back
 * @property string $song_profile_ids
 * @property string $video_profile_ids
 */
class BaseDevice2Model extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Device2 the static model class
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
		return 'device_2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, user_agent, model', 'length', 'max'=>100),
			array('brand, fall_back', 'length', 'max'=>50),
			array('marketing_name', 'length', 'max'=>30),
			array('description', 'length', 'max'=>255),
			array('os, song_profile_ids, video_profile_ids', 'length', 'max'=>45),
			array('resolution, is_tablet, is_smarttv', 'length', 'max'=>15),
			array('streaming_preferred_protocol', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_id, user_agent, model, brand, marketing_name, description, os, resolution, is_tablet, is_smarttv, streaming_preferred_protocol, fall_back, song_profile_ids, video_profile_ids', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('marketing_name',$this->marketing_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('resolution',$this->resolution,true);
		$criteria->compare('is_tablet',$this->is_tablet,true);
		$criteria->compare('is_smarttv',$this->is_smarttv,true);
		$criteria->compare('streaming_preferred_protocol',$this->streaming_preferred_protocol,true);
		$criteria->compare('fall_back',$this->fall_back,true);
		$criteria->compare('song_profile_ids',$this->song_profile_ids,true);
		$criteria->compare('video_profile_ids',$this->video_profile_ids,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}