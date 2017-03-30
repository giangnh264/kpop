<?php

/**
 * This is the model class for table "api_source".
 *
 * The followings are the available columns in table 'api_source':
 * @property integer $id
 * @property string $name
 * @property string $api_url
 * @property string $protocol
 * @property string $method
 * @property string $partner
 * @property string $object_type
 * @property string $params
 */
class BaseApiSourceModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ApiSource the static model class
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
		return 'api_source';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, api_url, partner', 'required'),
			array('name, api_url', 'length', 'max'=>255),
			array('protocol', 'length', 'max'=>4),
			array('method', 'length', 'max'=>100),
			array('partner', 'length', 'max'=>25),
			array('object_type', 'length', 'max'=>6),
			array('params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, api_url, protocol, method, partner, object_type, params', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('api_url',$this->api_url,true);
		$criteria->compare('protocol',$this->protocol,true);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('partner',$this->partner,true);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}