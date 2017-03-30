<?php

/**
 * This is the model class for table "copyright".
 *
 * The followings are the available columns in table 'copyright':
 * @property integer $id
 * @property integer $ccp
 * @property integer $type
 * @property string $title
 * @property string $contract_no
 * @property string $appendix_no
 * @property string $provider
 * @property string $copyright_method
 * @property string $start_date
 * @property string $due_date
 * @property string $added_by
 * @property string $added_time
 * @property string $updated_by
 * @property string $updated_time
 * @property integer $status
 * @property integer $priority
 */
class BaseCopyrightModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Copyright the static model class
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
		return 'copyright';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ccp, type, status, priority', 'numerical', 'integerOnly'=>true),
			array('title, contract_no, appendix_no, provider', 'length', 'max'=>255),
			array('copyright_method', 'length', 'max'=>45),
			array('added_by, updated_by', 'length', 'max'=>10),
			array('start_date, due_date, added_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ccp, type, title, contract_no, appendix_no, provider, copyright_method, start_date, due_date, added_by, added_time, updated_by, updated_time, status, priority', 'safe', 'on'=>'search'),
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
		$criteria->compare('ccp',$this->ccp);
		$criteria->compare('type',$this->type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('contract_no',$this->contract_no,true);
		$criteria->compare('appendix_no',$this->appendix_no,true);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('copyright_method',$this->copyright_method,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('added_by',$this->added_by,true);
		$criteria->compare('added_time',$this->added_time,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}