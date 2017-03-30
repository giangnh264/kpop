<?php

/**
 * This is the model class for table "user_charge_remain_cycle".
 *
 * The followings are the available columns in table 'user_charge_remain_cycle':
 * @property string $msisdn
 * @property integer $package_id
 * @property string $remain
 * @property integer $retry_on_day
 * @property integer $retry_on_cycle
 * @property string $end_date
 * @property string $charge_date
 * @property string $last_success_time
 * @property string $last_updated_time
 */
class BaseUserChargeRemainCycleModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChargeRemainCycle the static model class
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
		return 'user_charge_remain_cycle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn, package_id, remain, retry_on_cycle', 'required'),
			array('package_id, retry_on_day, retry_on_cycle', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>20),
			array('remain', 'length', 'max'=>150),
			array('end_date, charge_date, last_success_time, last_updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('msisdn, package_id, remain, retry_on_day, retry_on_cycle, end_date, charge_date, last_success_time, last_updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('remain',$this->remain,true);
		$criteria->compare('retry_on_day',$this->retry_on_day);
		$criteria->compare('retry_on_cycle',$this->retry_on_cycle);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('charge_date',$this->charge_date,true);
		$criteria->compare('last_success_time',$this->last_success_time,true);
		$criteria->compare('last_updated_time',$this->last_updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}