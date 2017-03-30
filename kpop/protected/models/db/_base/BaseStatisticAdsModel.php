<?php

/**
 * This is the model class for table "statistic_ads".
 *
 * The followings are the available columns in table 'statistic_ads':
 * @property string $date
 * @property string $ads
 * @property integer $click_total
 * @property integer $click_3g
 * @property integer $click_unique
 * @property integer $click_detect
 * @property integer $click_detect_unique
 * @property integer $total_subs_success
 * @property integer $total_unsubs
 * @property integer $total_subs_fail
 * @property integer $total_subs_ext_success
 * @property double $total_revenue_subs
 * @property double $total_revenue_ext
 * @property double $total_revenue_content
 */
class BaseStatisticAdsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticAds the static model class
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
		return 'statistic_ads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date', 'required'),
			array('click_total, click_3g, click_unique, click_detect, click_detect_unique, total_subs_success, total_unsubs, total_subs_fail, total_subs_ext_success', 'numerical', 'integerOnly'=>true),
			array('total_revenue_subs, total_revenue_ext, total_revenue_content', 'numerical'),
			array('ads', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, ads, click_total, click_3g, click_unique, click_detect, click_detect_unique, total_subs_success, total_unsubs, total_subs_fail, total_subs_ext_success, total_revenue_subs, total_revenue_ext, total_revenue_content', 'safe', 'on'=>'search'),
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
		$criteria->compare('ads',$this->ads,true);
		$criteria->compare('click_total',$this->click_total);
		$criteria->compare('click_3g',$this->click_3g);
		$criteria->compare('click_unique',$this->click_unique);
		$criteria->compare('click_detect',$this->click_detect);
		$criteria->compare('click_detect_unique',$this->click_detect_unique);
		$criteria->compare('total_subs_success',$this->total_subs_success);
		$criteria->compare('total_unsubs',$this->total_unsubs);
		$criteria->compare('total_subs_fail',$this->total_subs_fail);
		$criteria->compare('total_subs_ext_success',$this->total_subs_ext_success);
		$criteria->compare('total_revenue_subs',$this->total_revenue_subs);
		$criteria->compare('total_revenue_ext',$this->total_revenue_ext);
		$criteria->compare('total_revenue_content',$this->total_revenue_content);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}