<?php

/**
 * This is the model class for table "log_cdr".
 *
 * The followings are the available columns in table 'log_cdr':
 * @property string $id
 * @property string $user_id
 * @property string $user_phone
 * @property string $transaction
 * @property string $channel
 * @property string $obj1_id
 * @property string $obj1_name
 * @property string $obj2_id
 * @property string $obj2_name
 * @property integer $package_id
 * @property integer $cp_id
 * @property string $cp_name
 * @property integer $genre_id
 * @property double $price
 * @property double $origin_price
 * @property string $promotion
 * @property string $note
 * @property string $reason
 * @property string $content_code
 * @property string $content_type
 * @property string $genre_type
 * @property string $request_id
 * @property string $request_xml
 * @property string $response_xml
 * @property string $created_time
 */
class BaseLogCdrModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogCdr the static model class
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
		return 'log_cdr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, transaction, channel, created_time', 'required'),
			array('package_id, cp_id, genre_id', 'numerical', 'integerOnly'=>true),
			array('price, origin_price', 'numerical'),
			array('user_id, obj1_id, obj2_id, promotion, genre_type', 'length', 'max'=>10),
			array('user_phone', 'length', 'max'=>16),
			array('transaction, channel', 'length', 'max'=>50),
			array('obj1_name, obj2_name, cp_name', 'length', 'max'=>255),
			array('note, content_code, request_id', 'length', 'max'=>150),
			array('reason', 'length', 'max'=>100),
			array('content_type', 'length', 'max'=>30),
			array('request_xml, response_xml', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, transaction, channel, obj1_id, obj1_name, obj2_id, obj2_name, package_id, cp_id, cp_name, genre_id, price, origin_price, promotion, note, reason, content_code, content_type, genre_type, request_id, request_xml, response_xml, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('transaction',$this->transaction,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('obj1_id',$this->obj1_id,true);
		$criteria->compare('obj1_name',$this->obj1_name,true);
		$criteria->compare('obj2_id',$this->obj2_id,true);
		$criteria->compare('obj2_name',$this->obj2_name,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('cp_name',$this->cp_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('origin_price',$this->origin_price);
		$criteria->compare('promotion',$this->promotion,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('content_code',$this->content_code,true);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('genre_type',$this->genre_type,true);
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('request_xml',$this->request_xml,true);
		$criteria->compare('response_xml',$this->response_xml,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}