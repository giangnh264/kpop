<?php

/**
 * This is the model class for table "email_server".
 *
 * The followings are the available columns in table 'email_server':
 * @property integer $id
 * @property string $name
 * @property string $smtp_host
 * @property integer $smtp_port
 * @property string $smtp_user
 * @property string $smtp_pass
 */
class BaseEmailServerModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmailServer the static model class
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
		return 'email_server';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('smtp_port', 'numerical', 'integerOnly'=>true),
			array('name, smtp_host, smtp_pass', 'length', 'max'=>255),
			array('smtp_user', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, smtp_host, smtp_port, smtp_user, smtp_pass', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('smtp_host',$this->smtp_host,true);
		$criteria->compare('smtp_port',$this->smtp_port);
		$criteria->compare('smtp_user',$this->smtp_user,true);
		$criteria->compare('smtp_pass',$this->smtp_pass,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}