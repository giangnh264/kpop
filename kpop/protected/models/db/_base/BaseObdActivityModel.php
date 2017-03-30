<?php

/**
 * This is the model class for table "obd_activity".
 *
 * The followings are the available columns in table 'obd_activity':
 * @property integer $id
 * @property string $phone
 * @property integer $group_id
 * @property string $activity
 * @property string $response_key
 * @property string $error_code
 * @property string $error_msg
 * @property string $duration
 * @property string $created_time
 * @property integer $status
 */
class BaseObdActivityModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ObdActivity the static model class
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
		return 'obd_activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phone, activity', 'required'),
			array('group_id, status', 'numerical', 'integerOnly'=>true),
			array('phone, activity', 'length', 'max'=>20),
			array('response_key', 'length', 'max'=>5),
			array('error_code, duration', 'length', 'max'=>10),
			array('error_msg', 'length', 'max'=>150),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, phone, group_id, activity, response_key, error_code, error_msg, duration, created_time, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('response_key',$this->response_key,true);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('error_msg',$this->error_msg,true);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}