<?php

/**
 * This is the model class for table "log_download_song".
 *
 * The followings are the available columns in table 'log_download_song':
 * @property integer $id
 * @property string $song_name
 * @property integer $song_id
 * @property integer $user_id
 * @property string $user_phone
 * @property integer $package_id
 * @property string $ip
 * @property string $user_agent
 * @property string $created_datetime
 */
class BaseLogDownloadSongModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogDownloadSong the static model class
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
		return 'log_download_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('song_id, user_id, package_id', 'numerical', 'integerOnly'=>true),
			array('song_name, user_phone, user_agent', 'length', 'max'=>255),
			array('ip', 'length', 'max'=>20),
			array('created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, song_name, song_id, user_id, user_phone, package_id, ip, user_agent, created_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_name',$this->song_name,true);
		$criteria->compare('song_id',$this->song_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}