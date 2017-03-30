<?php

/**
 * This is the model class for table "log_api_consume".
 *
 * The followings are the available columns in table 'log_api_consume':
 * @property integer $id
 * @property string $loged_time
 * @property string $server_ip
 * @property string $service_name
 * @property string $service_url
 * @property string $request_params
 * @property string $protocol
 * @property string $start_time
 * @property string $end_time
 * @property integer $execute_time
 * @property string $response
 */
class BaseLogApiConsumeModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogApiConsume the static model class
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
		return 'log_api_consume';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loged_time, server_ip, service_name, service_url, start_time, response', 'required'),
			array('execute_time', 'numerical', 'integerOnly'=>true),
			array('server_ip, service_name, service_url, request_params', 'length', 'max'=>255),
			array('protocol', 'length', 'max'=>30),
			array('end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, loged_time, server_ip, service_name, service_url, request_params, protocol, start_time, end_time, execute_time, response', 'safe', 'on'=>'search'),
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
		$criteria->compare('loged_time',$this->loged_time,true);
		$criteria->compare('server_ip',$this->server_ip,true);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('service_url',$this->service_url,true);
		$criteria->compare('request_params',$this->request_params,true);
		$criteria->compare('protocol',$this->protocol,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('execute_time',$this->execute_time);
		$criteria->compare('response',$this->response,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}