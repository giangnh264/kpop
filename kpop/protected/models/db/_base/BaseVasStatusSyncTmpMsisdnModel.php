<?php

/**
 * This is the model class for table "vas_status_sync_tmp_msisdn".
 *
 * The followings are the available columns in table 'vas_status_sync_tmp_msisdn':
 * @property integer $id
 * @property integer $vas_status_file_id
 * @property string $file_name
 * @property string $msisdn
 * @property integer $vas_status
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 */
class BaseVasStatusSyncTmpMsisdnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VasStatusSyncTmpMsisdn the static model class
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
		return 'vas_status_sync_tmp_msisdn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vas_status_file_id, msisdn', 'required'),
			array('vas_status_file_id, vas_status, status', 'numerical', 'integerOnly'=>true),
			array('file_name', 'length', 'max'=>255),
			array('msisdn', 'length', 'max'=>25),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vas_status_file_id, file_name, msisdn, vas_status, status, created_time, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('vas_status_file_id',$this->vas_status_file_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('vas_status',$this->vas_status);
		$criteria->compare('status',$this->status);
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