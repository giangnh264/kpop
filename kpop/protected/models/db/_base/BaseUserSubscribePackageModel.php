<?php

/**
 * This is the model class for table "user_subscribe_package".
 *
 * The followings are the available columns in table 'user_subscribe_package':
 * @property string $user_phone
 * @property integer $package_id
 * @property integer $bundle
 * @property integer $duration
 * @property string $source
 * @property string $event
 * @property string $created_time
 */
class BaseUserSubscribePackageModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribePackage the static model class
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
		return 'user_subscribe_package';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_phone, package_id, source', 'required'),
			array('package_id, bundle, duration', 'numerical', 'integerOnly'=>true),
			array('user_phone, source', 'length', 'max'=>20),
			array('event', 'length', 'max'=>255),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_phone, package_id, bundle, duration, source, event, created_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('bundle',$this->bundle);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}