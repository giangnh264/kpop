<?php

/**
 * This is the model class for table "statistic_ringtone".
 *
 * The followings are the available columns in table 'statistic_ringtone':
 * @property string $date
 * @property string $ringtone_id
 * @property integer $category_id
 * @property integer $cp_id
 * @property string $artist_id
 * @property string $downloaded_count
 * @property double $revenue
 */
class BaseStatisticRingtoneModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticRingtone the static model class
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
		return 'statistic_ringtone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, ringtone_id', 'required'),
			array('category_id, cp_id', 'numerical', 'integerOnly'=>true),
			array('revenue', 'numerical'),
			array('ringtone_id, artist_id, downloaded_count', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, ringtone_id, category_id, cp_id, artist_id, downloaded_count, revenue', 'safe', 'on'=>'search'),
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('ringtone_id',$this->ringtone_id,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('downloaded_count',$this->downloaded_count,true);
		$criteria->compare('revenue',$this->revenue);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}