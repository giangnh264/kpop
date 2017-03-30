<?php

/**
 * This is the model class for table "statistic_song".
 *
 * The followings are the available columns in table 'statistic_song':
 * @property string $date
 * @property string $song_id
 * @property string $song_name
 * @property integer $genre_id
 * @property integer $cp_id
 * @property integer $ccp_id
 * @property integer $ccpr_id
 * @property string $artist_id
 * @property string $played_count
 * @property integer $played_count_wap
 * @property integer $played_count_api_ios
 * @property integer $played_count_api_android
 * @property string $downloaded_count
 * @property integer $downloaded_count_web
 * @property integer $downloaded_count_wap
 * @property integer $downloaded_count_api_ios
 * @property integer $downloaded_count_api_android
 * @property string $revenue_play_wap
 * @property string $revenue_play_api_ios
 * @property string $revenue_play_api_android
 * @property string $revenue_play
 * @property string $revenue_download_web
 * @property string $revenue_download_wap
 * @property string $revenue_download_api_ios
 * @property string $revenue_download_android
 * @property string $revenue_download
 * @property string $play_not_free
 * @property string $download_not_free
 */
class BaseStatisticSongModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticSong the static model class
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
		return 'statistic_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, song_id', 'required'),
			array('genre_id, cp_id, ccp_id, ccpr_id, played_count_wap, played_count_api_ios, played_count_api_android, downloaded_count_web, downloaded_count_wap, downloaded_count_api_ios, downloaded_count_api_android', 'numerical', 'integerOnly'=>true),
			array('song_id, artist_id, played_count, downloaded_count', 'length', 'max'=>11),
			array('song_name', 'length', 'max'=>255),
			array('revenue_play_wap, revenue_play_api_ios, revenue_play_api_android, revenue_play, revenue_download_web, revenue_download_wap, revenue_download_api_ios, revenue_download_android, revenue_download, play_not_free, download_not_free', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, song_id, song_name, genre_id, cp_id, ccp_id, ccpr_id, artist_id, played_count, played_count_wap, played_count_api_ios, played_count_api_android, downloaded_count, downloaded_count_web, downloaded_count_wap, downloaded_count_api_ios, downloaded_count_api_android, revenue_play_wap, revenue_play_api_ios, revenue_play_api_android, revenue_play, revenue_download_web, revenue_download_wap, revenue_download_api_ios, revenue_download_android, revenue_download, play_not_free, download_not_free', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('song_name',$this->song_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('ccp_id',$this->ccp_id);
		$criteria->compare('ccpr_id',$this->ccpr_id);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('played_count',$this->played_count,true);
		$criteria->compare('played_count_wap',$this->played_count_wap);
		$criteria->compare('played_count_api_ios',$this->played_count_api_ios);
		$criteria->compare('played_count_api_android',$this->played_count_api_android);
		$criteria->compare('downloaded_count',$this->downloaded_count,true);
		$criteria->compare('downloaded_count_web',$this->downloaded_count_web);
		$criteria->compare('downloaded_count_wap',$this->downloaded_count_wap);
		$criteria->compare('downloaded_count_api_ios',$this->downloaded_count_api_ios);
		$criteria->compare('downloaded_count_api_android',$this->downloaded_count_api_android);
		$criteria->compare('revenue_play_wap',$this->revenue_play_wap,true);
		$criteria->compare('revenue_play_api_ios',$this->revenue_play_api_ios,true);
		$criteria->compare('revenue_play_api_android',$this->revenue_play_api_android,true);
		$criteria->compare('revenue_play',$this->revenue_play,true);
		$criteria->compare('revenue_download_web',$this->revenue_download_web,true);
		$criteria->compare('revenue_download_wap',$this->revenue_download_wap,true);
		$criteria->compare('revenue_download_api_ios',$this->revenue_download_api_ios,true);
		$criteria->compare('revenue_download_android',$this->revenue_download_android,true);
		$criteria->compare('revenue_download',$this->revenue_download,true);
		$criteria->compare('play_not_free',$this->play_not_free,true);
		$criteria->compare('download_not_free',$this->download_not_free,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}