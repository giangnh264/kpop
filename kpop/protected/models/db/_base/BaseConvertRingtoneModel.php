<?php

/**
 * This is the model class for table "convert_ringtone".
 *
 * The followings are the available columns in table 'convert_ringtone':
 * @property integer $id
 * @property string $ringtone_id
 * @property string $source_path
 * @property string $begin_time
 * @property string $end_time
 * @property integer $status
 */
class BaseConvertRingtoneModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConvertRingtone the static model class
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
		return 'convert_ringtone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ringtone_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('ringtone_id', 'length', 'max'=>11),
			array('source_path', 'length', 'max'=>255),
			array('begin_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ringtone_id, source_path, begin_time, end_time, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('ringtone_id',$this->ringtone_id,true);
		$criteria->compare('source_path',$this->source_path,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}