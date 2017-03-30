<?php

/**
 * This is the model class for table "convert_rbt".
 *
 * The followings are the available columns in table 'convert_rbt':
 * @property integer $id
 * @property string $rbt_id
 * @property string $source_path
 * @property string $begin_time
 * @property string $end_time
 * @property integer $status
 * @property integer $mo_id
 */
class BaseConvertRbtModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConvertRbt the static model class
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
		return 'convert_rbt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_path, mo_id', 'required'),
			array('status, mo_id', 'numerical', 'integerOnly'=>true),
			array('rbt_id', 'length', 'max'=>11),
			array('source_path', 'length', 'max'=>255),
			array('begin_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rbt_id, source_path, begin_time, end_time, status, mo_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('rbt_id',$this->rbt_id,true);
		$criteria->compare('source_path',$this->source_path,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('mo_id',$this->mo_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}