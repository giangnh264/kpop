<?php

/**
 * This is the model class for table "device_video_profile".
 *
 * The followings are the available columns in table 'device_video_profile':
 * @property integer $id
 * @property string $device_id
 * @property integer $song_profile_id
 * @property integer $video_profile_id
 */
class BaseDeviceVideoProfileModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DeviceVideoProfile the static model class
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
		return 'device_video_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id', 'required'),
			array('song_profile_id, video_profile_id', 'numerical', 'integerOnly'=>true),
			array('device_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_id, song_profile_id, video_profile_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('song_profile_id',$this->song_profile_id);
		$criteria->compare('video_profile_id',$this->video_profile_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
}