<?php

/**
 * This is the model class for table "rbt_download".
 *
 * The followings are the available columns in table 'rbt_download':
 * @property string $id
 * @property string $rbt_id
 * @property string $rbt_code
 * @property string $user_id
 * @property string $from_phone
 * @property string $to_phone
 * @property double $price
 * @property string $amount
 * @property string $message
 * @property string $channel
 * @property string $download_datetime
 */
class BaseRbtDownloadModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtDownload the static model class
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
		return 'rbt_download';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rbt_id, user_id', 'required'),
			array('price', 'numerical'),
			array('rbt_id, user_id, amount', 'length', 'max'=>11),
			array('rbt_code', 'length', 'max'=>50),
			array('from_phone, to_phone, channel', 'length', 'max'=>20),
			array('message', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rbt_id, rbt_code, user_id, from_phone, to_phone, price, amount, message, channel, download_datetime', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('rbt_id',$this->rbt_id,true);
		$criteria->compare('rbt_code',$this->rbt_code,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('from_phone',$this->from_phone,true);
		$criteria->compare('to_phone',$this->to_phone,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('download_datetime',$this->download_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}