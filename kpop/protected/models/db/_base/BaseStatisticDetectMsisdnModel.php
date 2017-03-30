<?php

/**
 * This is the model class for table "statistic_detect_msisdn".
 *
 * The followings are the available columns in table 'statistic_detect_msisdn':
 * @property string $date
 * @property string $total_count
 * @property string $sucessful_count
 * @property integer $phone_count
 * @property integer $subs_count
 * @property integer $total_count_wap
 * @property integer $sucessful_count_wap
 * @property integer $subs_count_wap
 * @property integer $total_count_ios
 * @property integer $sucessful_count_ios
 * @property integer $subs_count_ios
 * @property integer $total_count_android
 * @property integer $sucessful_count_android
 * @property integer $subs_count_android
 */
class BaseStatisticDetectMsisdnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticDetectMsisdn the static model class
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
		return 'statistic_detect_msisdn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, phone_count', 'required'),
			array('phone_count, subs_count, total_count_wap, sucessful_count_wap, subs_count_wap, total_count_ios, sucessful_count_ios, subs_count_ios, total_count_android, sucessful_count_android, subs_count_android', 'numerical', 'integerOnly'=>true),
			array('total_count, sucessful_count', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, total_count, sucessful_count, phone_count, subs_count, total_count_wap, sucessful_count_wap, subs_count_wap, total_count_ios, sucessful_count_ios, subs_count_ios, total_count_android, sucessful_count_android, subs_count_android', 'safe', 'on'=>'search'),
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
		$criteria->compare('total_count',$this->total_count,true);
		$criteria->compare('sucessful_count',$this->sucessful_count,true);
		$criteria->compare('phone_count',$this->phone_count);
		$criteria->compare('subs_count',$this->subs_count);
		$criteria->compare('total_count_wap',$this->total_count_wap);
		$criteria->compare('sucessful_count_wap',$this->sucessful_count_wap);
		$criteria->compare('subs_count_wap',$this->subs_count_wap);
		$criteria->compare('total_count_ios',$this->total_count_ios);
		$criteria->compare('sucessful_count_ios',$this->sucessful_count_ios);
		$criteria->compare('subs_count_ios',$this->subs_count_ios);
		$criteria->compare('total_count_android',$this->total_count_android);
		$criteria->compare('sucessful_count_android',$this->sucessful_count_android);
		$criteria->compare('subs_count_android',$this->subs_count_android);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}