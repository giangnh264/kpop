<?php

/**
 * This is the model class for table "user_monfee".
 *
 * The followings are the available columns in table 'user_monfee':
 * @property integer $id
 * @property string $msisdn
 * @property string $expired_time
 * @property integer $page
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 * @property integer $package_id
 * @property integer $retry_on_day
 * @property string $type
 */
class BaseUserMonfeeModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserMonfee the static model class
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
		return 'user_monfee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msisdn, page, status, created_time, updated_time, package_id', 'required'),
			array('page, status, package_id, retry_on_day', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>15),
			array('type', 'length', 'max'=>100),
			array('expired_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, msisdn, expired_time, page, status, created_time, updated_time, package_id, retry_on_day, type', 'safe', 'on'=>'search'),
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
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('expired_time',$this->expired_time,true);
		$criteria->compare('page',$this->page);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('retry_on_day',$this->retry_on_day);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}