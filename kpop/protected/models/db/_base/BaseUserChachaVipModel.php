<?php

/**
 * This is the model class for table "user_chacha_vip".
 *
 * The followings are the available columns in table 'user_chacha_vip':
 * @property integer $id
 * @property string $user_phone
 * @property integer $transaction_count
 * @property string $from_datetime
 * @property string $to_datetime
 * @property string $note
 * @property string $created_datetime
 */
class BaseUserChachaVipModel extends MainContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChachaVip the static model class
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
		return 'user_chacha_vip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_phone', 'required'),
			array('transaction_count', 'numerical', 'integerOnly'=>true),
			array('user_phone', 'length', 'max'=>15),
			array('note', 'length', 'max'=>255),
			array('from_datetime, to_datetime, created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_phone, transaction_count, from_datetime, to_datetime, note, created_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('transaction_count',$this->transaction_count);
		$criteria->compare('from_datetime',$this->from_datetime,true);
		$criteria->compare('to_datetime',$this->to_datetime,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}