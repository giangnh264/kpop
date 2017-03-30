<?php

/**
 * This is the model class for table "solr_album".
 *
 * The followings are the available columns in table 'solr_album':
 * @property string $type
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $artist_id
 * @property string $artist_name
 * @property integer $genre_id
 * @property string $genre_name
 * @property integer $song_count
 * @property string $updated_time
 */
class BaseSolrAlbumModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolrAlbum the static model class
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
		return 'solr_album';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('genre_id, song_count', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>5),
			array('id', 'length', 'max'=>15),
			array('name, url_key, artist_name', 'length', 'max'=>160),
			array('artist_id', 'length', 'max'=>10),
			array('genre_name', 'length', 'max'=>150),
			array('updated_time', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type, id, name, url_key, artist_id, artist_name, genre_id, genre_name, song_count, updated_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('type',$this->type,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('genre_name',$this->genre_name,true);
		$criteria->compare('song_count',$this->song_count);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}