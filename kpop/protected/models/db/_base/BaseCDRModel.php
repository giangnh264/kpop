<?php

/**
 * This is the model class for table "CDR".
 *
 * The followings are the available columns in table 'CDR':
 * @property string $ID
 * @property string $CREATED_TIME
 * @property string $MSISDN
 * @property string $SHORT_CODE
 * @property string $CATEGORY_ID
 * @property string $CP_ID
 * @property string $CONTENT_ID
 * @property integer $STATUS
 * @property string $COST
 * @property string $CHANNEL_TYPE
 * @property string $INFORMATION
 * @property integer $IS_SEND
 */
class BaseCDRModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CDR the static model class
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
		return 'CDR';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CREATED_TIME, MSISDN, SHORT_CODE, CATEGORY_ID, CP_ID, CONTENT_ID, STATUS, COST, CHANNEL_TYPE, INFORMATION', 'required'),
			array('STATUS, IS_SEND', 'numerical', 'integerOnly'=>true),
			array('MSISDN, SHORT_CODE, CHANNEL_TYPE', 'length', 'max'=>15),
			array('CATEGORY_ID, CP_ID, CONTENT_ID, COST', 'length', 'max'=>10),
			array('INFORMATION', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CREATED_TIME, MSISDN, SHORT_CODE, CATEGORY_ID, CP_ID, CONTENT_ID, STATUS, COST, CHANNEL_TYPE, INFORMATION, IS_SEND', 'safe', 'on'=>'search'),
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

		$criteria->compare('ID',$this->ID,true);
		$criteria->compare('CREATED_TIME',$this->CREATED_TIME,true);
		$criteria->compare('MSISDN',$this->MSISDN,true);
		$criteria->compare('SHORT_CODE',$this->SHORT_CODE,true);
		$criteria->compare('CATEGORY_ID',$this->CATEGORY_ID,true);
		$criteria->compare('CP_ID',$this->CP_ID,true);
		$criteria->compare('CONTENT_ID',$this->CONTENT_ID,true);
		$criteria->compare('STATUS',$this->STATUS);
		$criteria->compare('COST',$this->COST,true);
		$criteria->compare('CHANNEL_TYPE',$this->CHANNEL_TYPE,true);
		$criteria->compare('INFORMATION',$this->INFORMATION,true);
		$criteria->compare('IS_SEND',$this->IS_SEND);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}