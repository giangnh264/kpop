<?php

/**
 * This is the model class for table "log_url_return".
 *
 * The followings are the available columns in table 'log_url_return':
 * @property string $id
 * @property string $msisdn
 * @property string $user_ip
 * @property string $user_agent
 * @property string $device_id
 * @property string $action
 * @property string $obj_id
 * @property string $return_url
 * @property string $channel
 * @property string $created_time
 */
class BaseLogUrlReturnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogUrlReturn the static model class
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
		return 'log_url_return';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn', 'length', 'max'=>40),
			array('user_ip, action', 'length', 'max'=>50),
			array('user_agent', 'length', 'max'=>400),
			array('device_id, return_url', 'length', 'max'=>255),
			array('obj_id, channel', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, msisdn, user_ip, user_agent, device_id, action, obj_id, return_url, channel, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('obj_id',$this->obj_id,true);
		$criteria->compare('return_url',$this->return_url,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}