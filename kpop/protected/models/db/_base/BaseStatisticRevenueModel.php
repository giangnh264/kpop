<?php

/**
 * This is the model class for table "statistic_revenue".
 *
 * The followings are the available columns in table 'statistic_revenue':
 * @property string $date
 * @property string $song_revenue
 * @property string $song_play_revenue
 * @property string $song_download_revenue
 * @property string $video_revenue
 * @property string $video_play_revenue
 * @property string $video_download_revenue
 * @property string $ringtone_revenue
 * @property string $rbt_revenue
 * @property string $album_revenue
 * @property string $subscribe_revenue
 * @property string $subscribe_ext_revenue
 * @property string $total_revenue
 */
class BaseStatisticRevenueModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticRevenue the static model class
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
		return 'statistic_revenue';
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
			array('song_revenue, song_play_revenue, song_download_revenue, video_revenue, video_play_revenue, video_download_revenue, ringtone_revenue, rbt_revenue, album_revenue, subscribe_revenue, subscribe_ext_revenue, total_revenue', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, song_revenue, song_play_revenue, song_download_revenue, video_revenue, video_play_revenue, video_download_revenue, ringtone_revenue, rbt_revenue, album_revenue, subscribe_revenue, subscribe_ext_revenue, total_revenue', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_revenue',$this->song_revenue,true);
		$criteria->compare('song_play_revenue',$this->song_play_revenue,true);
		$criteria->compare('song_download_revenue',$this->song_download_revenue,true);
		$criteria->compare('video_revenue',$this->video_revenue,true);
		$criteria->compare('video_play_revenue',$this->video_play_revenue,true);
		$criteria->compare('video_download_revenue',$this->video_download_revenue,true);
		$criteria->compare('ringtone_revenue',$this->ringtone_revenue,true);
		$criteria->compare('rbt_revenue',$this->rbt_revenue,true);
		$criteria->compare('album_revenue',$this->album_revenue,true);
		$criteria->compare('subscribe_revenue',$this->subscribe_revenue,true);
		$criteria->compare('subscribe_ext_revenue',$this->subscribe_ext_revenue,true);
		$criteria->compare('total_revenue',$this->total_revenue,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}