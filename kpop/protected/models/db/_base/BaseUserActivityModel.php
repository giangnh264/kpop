<?php

/**
 * This is the model class for table "user_activity".
 *
 * The followings are the available columns in table 'user_activity':
 * @property string $id
 * @property string $user_id
 * @property string $user_phone
 * @property string $activity
 * @property string $channel
 * @property string $obj1_id
 * @property string $obj1_name
 * @property string $obj1_url_key
 * @property string $obj2_id
 * @property string $obj2_name
 * @property string $obj2_url_key
 * @property string $note
 * @property string $loged_time
 */
class BaseUserActivityModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserActivity the static model class
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
		return 'user_activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, activity, channel, loged_time', 'required'),
			array('user_id, obj1_id, obj2_id', 'length', 'max'=>10),
			array('user_phone', 'length', 'max'=>16),
			array('activity', 'length', 'max'=>19),
			array('channel', 'length', 'max'=>11),
			array('obj1_name, obj1_url_key, obj2_name, obj2_url_key', 'length', 'max'=>160),
			array('note', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, activity, channel, obj1_id, obj1_name, obj1_url_key, obj2_id, obj2_name, obj2_url_key, note, loged_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('obj1_id',$this->obj1_id,true);
		$criteria->compare('obj1_name',$this->obj1_name,true);
		$criteria->compare('obj1_url_key',$this->obj1_url_key,true);
		$criteria->compare('obj2_id',$this->obj2_id,true);
		$criteria->compare('obj2_name',$this->obj2_name,true);
		$criteria->compare('obj2_url_key',$this->obj2_url_key,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('loged_time',$this->loged_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}