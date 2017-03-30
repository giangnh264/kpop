<?php

/**
 * This is the model class for table "log_api_vinaphone".
 *
 * The followings are the available columns in table 'log_api_vinaphone':
 * @property integer $id
 * @property string $request_id
 * @property string $msisdn_a
 * @property string $msisdn_b
 * @property integer $promotion
 * @property string $reason
 * @property string $username
 * @property string $clientip
 * @property string $channel
 * @property string $created_datetime
 * @property string $type
 * @property string $error_id
 * @property string $error_desc
 */
class BaseLogApiVinaphoneModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogApiVinaphone the static model class
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
		return 'log_api_vinaphone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promotion', 'numerical', 'integerOnly'=>true),
			array('request_id, reason, username, clientip, channel, type, error_desc', 'length', 'max'=>255),
			array('msisdn_a, msisdn_b', 'length', 'max'=>20),
			array('error_id', 'length', 'max'=>40),
			array('created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_id, msisdn_a, msisdn_b, promotion, reason, username, clientip, channel, created_datetime, type, error_id, error_desc', 'safe', 'on'=>'search'),
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
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('msisdn_a',$this->msisdn_a,true);
		$criteria->compare('msisdn_b',$this->msisdn_b,true);
		$criteria->compare('promotion',$this->promotion);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('clientip',$this->clientip,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('error_id',$this->error_id,true);
		$criteria->compare('error_desc',$this->error_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}