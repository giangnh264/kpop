<?php

/**
 * This is the model class for table "ringtone_category".
 *
 * The followings are the available columns in table 'ringtone_category':
 * @property integer $id
 * @property string $name
 * @property string $url_key
 * @property integer $parent_id
 * @property string $description
 * @property integer $created_by
 * @property integer $sorder
 * @property integer $status
 */
class BaseRingtoneCategoryModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RingtoneCategory the static model class
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
		return 'ringtone_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url_key, created_by', 'required'),
			array('parent_id, created_by, sorder, status', 'numerical', 'integerOnly'=>true),
			array('name, url_key', 'length', 'max'=>150),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, parent_id, description, created_by, sorder, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}