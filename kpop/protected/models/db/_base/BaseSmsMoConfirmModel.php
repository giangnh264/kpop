<?php

/**
 * This is the model class for table "sms_mo_confirm".
 *
 * The followings are the available columns in table 'sms_mo_confirm':
 * @property integer $id
 * @property string $msisdn
 * @property string $content
 * @property integer $package_id
 * @property string $created_time
 * @property integer $confirm_status
 */
class BaseSmsMoConfirmModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SmsMoConfirm the static model class
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
		return 'sms_mo_confirm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('package_id, confirm_status', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>25),
			array('content', 'length', 'max'=>255),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, msisdn, content, package_id, created_time, confirm_status', 'safe', 'on'=>'search'),
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('confirm_status',$this->confirm_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}