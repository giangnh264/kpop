<?php

/**
 * This is the model class for table "blacklist".
 *
 * The followings are the available columns in table 'blacklist':
 * @property string $msisdn
 * @property string $created_time
 * @property string $type
 * @property string $value
 */
class BaseBlacklistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Blacklist the static model class
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
		return 'blacklist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn', 'required'),
			array('msisdn', 'length', 'max'=>20),
			array('type, value', 'length', 'max'=>255),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('msisdn, created_time, type, value', 'safe', 'on'=>'search'),
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

		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}