<?php

/**
 * This is the model class for table "store_song".
 *
 * The followings are the available columns in table 'store_song':
 * @property string $id
 * @property string $title
 * @property string $artist
 * @property integer $chacha_artist_id
 * @property string $chacha_artist_name
 * @property string $album
 * @property string $genre
 * @property string $lyric
 * @property string $file_path
 */
class BaseStoreSongModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreSong the static model class
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
		return 'store_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('chacha_artist_id', 'numerical', 'integerOnly'=>true),
			array('title, artist, chacha_artist_name, album, genre, file_path', 'length', 'max'=>255),
			array('lyric', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, artist, chacha_artist_id, chacha_artist_name, album, genre, lyric, file_path', 'safe', 'on'=>'search'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('artist',$this->artist,true);
		$criteria->compare('chacha_artist_id',$this->chacha_artist_id);
		$criteria->compare('chacha_artist_name',$this->chacha_artist_name,true);
		$criteria->compare('album',$this->album,true);
		$criteria->compare('genre',$this->genre,true);
		$criteria->compare('lyric',$this->lyric,true);
		$criteria->compare('file_path',$this->file_path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}