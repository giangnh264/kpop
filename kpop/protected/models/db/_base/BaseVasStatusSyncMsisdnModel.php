<?php

/**
 * This is the model class for table "vas_status_sync_msisdn".
 *
 * The followings are the available columns in table 'vas_status_sync_msisdn':
 * @property integer $id
 * @property integer $vas_status_file_id
 * @property string $msisdn
 * @property integer $package_id
 * @property integer $vas_status
 * @property integer $sync_status
 * @property string $created_time
 * @property string $updated_time
 */
class BaseVasStatusSyncMsisdnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VasStatusSyncMsisdn the static model class
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
		return 'vas_status_sync_msisdn';
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
			array('vas_status_file_id, package_id, vas_status, sync_status', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>25),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vas_status_file_id, msisdn, package_id, vas_status, sync_status, created_time, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('vas_status',$this->vas_status);
		$criteria->compare('sync_status',$this->sync_status);
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