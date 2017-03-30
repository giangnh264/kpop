<?php

/**
 * This is the model class for table "tools_msisdn".
 *
 * The followings are the available columns in table 'tools_msisdn':
 * @property string $id
 * @property string $msisdn
 * @property integer $setting_id
 * @property string $code
 * @property string $created_datetime
 */
class BaseToolsMsisdnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ToolsMsisdn the static model class
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
		return 'tools_msisdn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setting_id', 'required'),
			array('setting_id', 'numerical', 'integerOnly'=>true),
			array('msisdn', 'length', 'max'=>15),
			array('code', 'length', 'max'=>10),
			array('created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, msisdn, setting_id, code, created_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('setting_id',$this->setting_id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}