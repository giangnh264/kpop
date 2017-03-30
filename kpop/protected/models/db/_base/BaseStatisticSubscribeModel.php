<?php

/**
 * This is the model class for table "statistic_subscribe".
 *
 * The followings are the available columns in table 'statistic_subscribe':
 * @property string $date
 * @property integer $package_id
 * @property string $active_count
 * @property string $subscribe_count
 * @property string $subscribe_ext_count
 * @property string $unsubscribe_count
 * @property string $expired_count
 * @property integer $ext_nextday
 */
class BaseStatisticSubscribeModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticSubscribe the static model class
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
		return 'statistic_subscribe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, package_id', 'required'),
			array('package_id, ext_nextday', 'numerical', 'integerOnly'=>true),
			array('active_count, subscribe_count, subscribe_ext_count, unsubscribe_count, expired_count', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, package_id, active_count, subscribe_count, subscribe_ext_count, unsubscribe_count, expired_count, ext_nextday', 'safe', 'on'=>'search'),
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('active_count',$this->active_count,true);
		$criteria->compare('subscribe_count',$this->subscribe_count,true);
		$criteria->compare('subscribe_ext_count',$this->subscribe_ext_count,true);
		$criteria->compare('unsubscribe_count',$this->unsubscribe_count,true);
		$criteria->compare('expired_count',$this->expired_count,true);
		$criteria->compare('ext_nextday',$this->ext_nextday);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}