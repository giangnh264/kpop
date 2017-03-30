<?php

/**
 * This is the model class for table "ringtone_statistic".
 *
 * The followings are the available columns in table 'ringtone_statistic':
 * @property integer $ringtone_id
 * @property string $old_id
 * @property string $downloaded_count
 */
class BaseRingtoneStatisticModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RingtoneStatistic the static model class
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
		return 'ringtone_statistic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ringtone_id', 'required'),
			array('ringtone_id', 'numerical', 'integerOnly'=>true),
			array('old_id', 'length', 'max'=>10),
			array('downloaded_count', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ringtone_id, old_id, downloaded_count', 'safe', 'on'=>'search'),
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

		$criteria->compare('ringtone_id',$this->ringtone_id);
		$criteria->compare('old_id',$this->old_id,true);
		$criteria->compare('downloaded_count',$this->downloaded_count,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}