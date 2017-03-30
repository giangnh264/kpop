<?php

/**
 * This is the model class for table "statistic_user_point".
 *
 * The followings are the available columns in table 'statistic_user_point':
 * @property integer $id
 * @property integer $user_id
 * @property string $user_phone
 * @property integer $point
 * @property integer $week
 * @property string $type
 * @property integer $promotion_week
 */
class BaseStatisticUserPointModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticUserPoint the static model class
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
		return 'statistic_user_point';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, point, week, promotion_week', 'numerical', 'integerOnly'=>true),
			array('user_phone', 'length', 'max'=>16),
			array('type', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, point, week, type, promotion_week', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('point',$this->point);
		$criteria->compare('week',$this->week);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('promotion_week',$this->promotion_week);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}