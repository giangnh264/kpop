<?php

/**
 * This is the model class for table "solr_artist".
 *
 * The followings are the available columns in table 'solr_artist':
 * @property string $type
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $song_count
 * @property string $video_count
 * @property string $album_count
 * @property integer $artist_type_id
 * @property string $description
 * @property string $updated_time
 */
class BaseSolrArtistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolrArtist the static model class
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
		return 'solr_artist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('artist_type_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>6),
			array('id', 'length', 'max'=>16),
			array('name, url_key', 'length', 'max'=>160),
			array('song_count, video_count, album_count', 'length', 'max'=>10),
			array('description, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type, id, name, url_key, song_count, video_count, album_count, artist_type_id, description, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_count',$this->song_count,true);
		$criteria->compare('video_count',$this->video_count,true);
		$criteria->compare('album_count',$this->album_count,true);
		$criteria->compare('artist_type_id',$this->artist_type_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}