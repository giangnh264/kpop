<?php

/**
 * This is the model class for table "tophot".
 *
 * The followings are the available columns in table 'tophot':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property integer $number_slot
 * @property string $note
 * @property integer $published
 * @property string $created_datetime
 * @property string $updated_datetime
 */
class BaseTophotModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tophot the static model class
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
		return 'tophot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, number_slot', 'required'),
			array('number_slot, published', 'numerical', 'integerOnly'=>true),
			array('name, note', 'length', 'max'=>255),
			array('code', 'length', 'max'=>100),
			array('type', 'length', 'max'=>5),
			array('created_datetime, updated_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, type, number_slot, note, published, created_datetime, updated_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('number_slot',$this->number_slot);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('updated_datetime',$this->updated_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}