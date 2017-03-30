<?php

/**
 * This is the model class for table "log_player".
 *
 * The followings are the available columns in table 'log_player':
 * @property string $id
 * @property string $user_id
 * @property string $obj_id
 * @property string $obj_type
 * @property integer $obj_duration
 * @property string $begin_time
 * @property string $end_time
 */
class BaseLogPlayerModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogPlayer the static model class
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
		return 'log_player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, obj_id, begin_time', 'required'),
			array('obj_duration', 'numerical', 'integerOnly'=>true),
			array('user_id, obj_id', 'length', 'max'=>10),
			array('obj_type', 'length', 'max'=>8),
			array('end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, obj_id, obj_type, obj_duration, begin_time, end_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('obj_id',$this->obj_id,true);
		$criteria->compare('obj_type',$this->obj_type,true);
		$criteria->compare('obj_duration',$this->obj_duration);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}