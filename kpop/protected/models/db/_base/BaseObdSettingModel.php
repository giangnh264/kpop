<?php

/**
 * This is the model class for table "obd_setting".
 *
 * The followings are the available columns in table 'obd_setting':
 * @property integer $id
 * @property string $scerano
 * @property string $from_date
 * @property string $to_date
 * @property integer $daily_start
 * @property integer $daily_finish
 * @property string $phone_group_ids
 * @property string $updated_by
 * @property string $updated_time
 * @property string $rbt_code
 * @property integer $status
 * @property string $rbt_name
 * @property integer $sync
 */
class BaseObdSettingModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ObdSetting the static model class
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
		return 'obd_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('scerano', 'required'),
			array('daily_start, daily_finish, status, sync', 'numerical', 'integerOnly'=>true),
			array('scerano', 'length', 'max'=>20),
			array('phone_group_ids, rbt_name', 'length', 'max'=>255),
			array('updated_by', 'length', 'max'=>10),
			array('rbt_code', 'length', 'max'=>25),
			array('from_date, to_date, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, scerano, from_date, to_date, daily_start, daily_finish, phone_group_ids, updated_by, updated_time, rbt_code, status, rbt_name, sync', 'safe', 'on'=>'search'),
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
		$criteria->compare('scerano',$this->scerano,true);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('daily_start',$this->daily_start);
		$criteria->compare('daily_finish',$this->daily_finish);
		$criteria->compare('phone_group_ids',$this->phone_group_ids,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('rbt_code',$this->rbt_code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('rbt_name',$this->rbt_name,true);
		$criteria->compare('sync',$this->sync);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}