<?php

/**
 * This is the model class for table "user_charge_remain".
 *
 * The followings are the available columns in table 'user_charge_remain':
 * @property integer $id
 * @property string $msisdn
 * @property integer $package_id
 * @property integer $remain
 * @property integer $retry_on_day
 * @property string $end_date
 * @property string $charge_date
 */
class BaseUserChargeRemainModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChargeRemain the static model class
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
		return 'user_charge_remain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn, package_id, remain, end_date', 'required'),
			array('package_id, remain, retry_on_day', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>30),
			array('charge_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, msisdn, package_id, remain, retry_on_day, end_date, charge_date', 'safe', 'on'=>'search'),
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
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('remain',$this->remain);
		$criteria->compare('retry_on_day',$this->retry_on_day);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('charge_date',$this->charge_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}