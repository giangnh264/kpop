<?php

/**
 * This is the model class for table "mg_dtmf_log".
 *
 * The followings are the available columns in table 'mg_dtmf_log':
 * @property string $id
 * @property string $start_call
 * @property string $end_call
 * @property string $msisdn
 * @property string $first_key
 * @property string $activity_log
 * @property string $total_time
 * @property integer $line_file
 * @property string $created_time
 */
class BaseMgDtmfLogModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MgDtmfLog the static model class
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
		return 'mg_dtmf_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn', 'required'),
			array('line_file', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>30),
			array('first_key', 'length', 'max'=>10),
			array('total_time', 'length', 'max'=>100),
			array('start_call, end_call, activity_log, created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start_call, end_call, msisdn, first_key, activity_log, total_time, line_file, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('start_call',$this->start_call,true);
		$criteria->compare('end_call',$this->end_call,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('first_key',$this->first_key,true);
		$criteria->compare('activity_log',$this->activity_log,true);
		$criteria->compare('total_time',$this->total_time,true);
		$criteria->compare('line_file',$this->line_file);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}