<?php

/**
 * This is the model class for table "rbt_category".
 *
 * The followings are the available columns in table 'rbt_category':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $created_datetime
 * @property integer $order_number
 * @property integer $status
 * @property string $ringtune_cat_id
 * @property string $ringtune_updated_datetime
 * @property string $display_name
 */
class BaseRbtCategoryModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtCategory the static model class
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
		return 'rbt_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, order_number, status', 'numerical', 'integerOnly'=>true),
			array('name, display_name', 'length', 'max'=>160),
			array('ringtune_cat_id', 'length', 'max'=>11),
			array('created_datetime, ringtune_updated_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent_id, created_datetime, order_number, status, ringtune_cat_id, ringtune_updated_datetime, display_name', 'safe', 'on'=>'search'),
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('order_number',$this->order_number);
		$criteria->compare('status',$this->status);
		$criteria->compare('ringtune_cat_id',$this->ringtune_cat_id,true);
		$criteria->compare('ringtune_updated_datetime',$this->ringtune_updated_datetime,true);
		$criteria->compare('display_name',$this->display_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}