<?php

/**
 * This is the model class for table "tophot_items".
 *
 * The followings are the available columns in table 'tophot_items':
 * @property integer $id
 * @property integer $tophot_slot_id
 * @property integer $content_id
 * @property string $content_type
 * @property integer $show_number
 */
class BaseTophotItemsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TophotItems the static model class
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
		return 'tophot_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tophot_slot_id, content_id, show_number', 'numerical', 'integerOnly'=>true),
			array('content_type', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tophot_slot_id, content_id, content_type, show_number', 'safe', 'on'=>'search'),
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
		$criteria->compare('tophot_slot_id',$this->tophot_slot_id);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('show_number',$this->show_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}