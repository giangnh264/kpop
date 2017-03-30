<?php

/**
 * This is the model class for table "text_link".
 *
 * The followings are the available columns in table 'text_link':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $position
 * @property string $created_time
 * @property integer $status
 * @property string $start_time
 * @property string $end_time
 * @property integer $is_app_link
 */
class BaseTextLinkModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TextLink the static model class
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
		return 'text_link';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url', 'required'),
			array('status, is_app_link', 'numerical', 'integerOnly'=>true),
			array('name, url, position', 'length', 'max'=>255),
			array('created_time, start_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, position, created_time, status, start_time, end_time, is_app_link', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('is_app_link',$this->is_app_link);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}