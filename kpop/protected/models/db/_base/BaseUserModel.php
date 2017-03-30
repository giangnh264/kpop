<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $old_id
 * @property string $username
 * @property string $password
 * @property string $fullname
 * @property string $phone
 * @property string $email
 * @property integer $gender
 * @property string $address
 * @property string $login_time
 * @property string $created_time
 * @property string $updated_time
 * @property integer $validate_phone
 * @property string $validate_phone_time
 * @property string $suggested_list
 * @property string $client_id
 * @property integer $status
 * @property string $last_time_block
 */
class BaseUserModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, phone', 'required'),
			array('gender, validate_phone, status', 'numerical', 'integerOnly'=>true),
			array('old_id', 'length', 'max'=>10),
			array('username, fullname, address', 'length', 'max'=>160),
			array('password', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>16),
			array('email', 'length', 'max'=>150),
			array('suggested_list', 'length', 'max'=>100),
			array('client_id', 'length', 'max'=>50),
			array('login_time, created_time, updated_time, validate_phone_time, last_time_block', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_id, username, password, fullname, phone, email, gender, address, login_time, created_time, updated_time, validate_phone, validate_phone_time, suggested_list, client_id, status, last_time_block', 'safe', 'on'=>'search'),
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
		$criteria->compare('old_id',$this->old_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('login_time',$this->login_time,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('validate_phone',$this->validate_phone);
		$criteria->compare('validate_phone_time',$this->validate_phone_time,true);
		$criteria->compare('suggested_list',$this->suggested_list,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('last_time_block',$this->last_time_block,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}