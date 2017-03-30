<?php

/**
 * This is the model class for table "solr_playlist".
 *
 * The followings are the available columns in table 'solr_playlist':
 * @property string $type
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $user_id
 * @property string $username
 * @property integer $song_count
 * @property string $artist_ids
 * @property string $updated_time
 */
class BaseSolrPlaylistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolrPlaylist the static model class
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
		return 'solr_playlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('song_count', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>8),
			array('id', 'length', 'max'=>18),
			array('name, url_key, username', 'length', 'max'=>160),
			array('user_id', 'length', 'max'=>10),
			array('artist_ids', 'length', 'max'=>40),
			array('updated_time', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type, id, name, url_key, user_id, username, song_count, artist_ids, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('song_count',$this->song_count);
		$criteria->compare('artist_ids',$this->artist_ids,true);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}