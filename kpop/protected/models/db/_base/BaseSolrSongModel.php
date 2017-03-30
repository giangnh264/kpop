<?php

/**
 * This is the model class for table "solr_song".
 *
 * The followings are the available columns in table 'solr_song':
 * @property string $TYPE
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $artist_id
 * @property string $artist_name
 * @property integer $genre_id
 * @property string $genre_name
 * @property double $download_price
 * @property double $listen_price
 * @property integer $max_bitrate
 * @property string $profile_ids
 * @property string $lyrics
 * @property string $updated_time
 */
class BaseSolrSongModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolrSong the static model class
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
		return 'solr_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('genre_id, max_bitrate', 'numerical', 'integerOnly'=>true),
			array('download_price, listen_price', 'numerical'),
			array('TYPE', 'length', 'max'=>4),
			array('id', 'length', 'max'=>14),
			array('name, url_key, artist_name, profile_ids', 'length', 'max'=>255),
			array('artist_id', 'length', 'max'=>10),
			array('genre_name', 'length', 'max'=>150),
			array('lyrics, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('TYPE, id, name, url_key, artist_id, artist_name, genre_id, genre_name, download_price, listen_price, max_bitrate, profile_ids, lyrics, updated_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('TYPE',$this->TYPE,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('genre_name',$this->genre_name,true);
		$criteria->compare('download_price',$this->download_price);
		$criteria->compare('listen_price',$this->listen_price);
		$criteria->compare('max_bitrate',$this->max_bitrate);
		$criteria->compare('profile_ids',$this->profile_ids,true);
		$criteria->compare('lyrics',$this->lyrics,true);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}