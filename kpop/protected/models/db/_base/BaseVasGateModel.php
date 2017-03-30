<?php

/**
 * This is the model class for table "vas_gate".
 *
 * The followings are the available columns in table 'vas_gate':
 * @property integer $id
 * @property string $transaction_id
 * @property integer $package_id
 * @property string $information
 * @property string $price
 * @property string $msisdn
 * @property string $created_time
 */
class BaseVasGateModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VasGate the static model class
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
		return 'vas_gate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, package_id, price', 'required'),
			array('package_id', 'numerical', 'integerOnly'=>true),
			array('transaction_id, information', 'length', 'max'=>255),
			array('price', 'length', 'max'=>10),
			array('msisdn', 'length', 'max'=>20),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_id, package_id, information, price, msisdn, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('information',$this->information,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}