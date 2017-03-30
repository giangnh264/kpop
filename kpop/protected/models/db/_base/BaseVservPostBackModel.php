<?php

/**
 * This is the model class for table "vserv_post_back".
 *
 * The followings are the available columns in table 'vserv_post_back':
 * @property integer $id
 * @property string $vserv
 * @property string $full_post_back_url
 * @property integer $return_code
 * @property string $created_time
 * @property string $user_phone
 */
class BaseVservPostBackModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VservPostBack the static model class
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
		return 'vserv_post_back';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_phone', 'required'),
			array('return_code', 'numerical', 'integerOnly'=>true),
			array('vserv', 'length', 'max'=>255),
			array('user_phone', 'length', 'max'=>16),
			array('full_post_back_url, created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vserv, full_post_back_url, return_code, created_time, user_phone', 'safe', 'on'=>'search'),
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
		$criteria->compare('vserv',$this->vserv,true);
		$criteria->compare('full_post_back_url',$this->full_post_back_url,true);
		$criteria->compare('return_code',$this->return_code);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('user_phone',$this->user_phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}