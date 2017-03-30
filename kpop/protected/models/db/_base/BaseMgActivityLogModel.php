<?php

/**
 * This is the model class for table "mg_activity_log".
 *
 * The followings are the available columns in table 'mg_activity_log':
 * @property string $id
 * @property string $start_call
 * @property string $end_call
 * @property string $gift_id
 * @property string $msisdn
 * @property string $description
 * @property integer $status
 * @property integer $type
 * @property string $created_time
 * @property string $updated_time
 */
class BaseMgActivityLogModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MgActivityLog the static model class
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
		return 'mg_activity_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('end_call, gift_id, msisdn', 'required'),
			array('status, type', 'numerical', 'integerOnly'=>true),
			array('start_call, end_call', 'length', 'max'=>255),
			array('gift_id', 'length', 'max'=>20),
			array('msisdn', 'length', 'max'=>50),
			array('description, created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start_call, end_call, gift_id, msisdn, description, status, type, created_time, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('gift_id',$this->gift_id,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}