<?php

/**
 * This is the model class for table "email_queue".
 *
 * The followings are the available columns in table 'email_queue':
 * @property string $id
 * @property string $template_id
 * @property string $to
 * @property string $params
 * @property integer $checked_out
 * @property integer $status
 */
class BaseEmailQueueModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmailQueue the static model class
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
		return 'email_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_id, to, params', 'required'),
			array('checked_out, status', 'numerical', 'integerOnly'=>true),
			array('template_id', 'length', 'max'=>10),
			array('to', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, template_id, to, params, checked_out, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('template_id',$this->template_id,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('checked_out',$this->checked_out);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}