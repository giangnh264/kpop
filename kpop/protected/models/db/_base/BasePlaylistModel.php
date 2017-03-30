<?php

/**
 * This is the model class for table "playlist".
 *
 * The followings are the available columns in table 'playlist':
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $user_id
 * @property string $username
 * @property string $msisdn
 * @property string $description
 * @property integer $song_count
 * @property string $artist_ids
 * @property integer $on_sidebar
 * @property integer $suggest_1
 * @property integer $suggest_2
 * @property integer $ivr_order
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 */
class BasePlaylistModel extends MainContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Playlist the static model class
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
		return 'playlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url_key', 'required'),
			array('song_count, on_sidebar, suggest_1, suggest_2, ivr_order, status', 'numerical', 'integerOnly'=>true),
			array('name, url_key, username', 'length', 'max'=>160),
			array('user_id', 'length', 'max'=>10),
			array('msisdn', 'length', 'max'=>20),
			array('description', 'length', 'max'=>500),
			array('artist_ids', 'length', 'max'=>40),
			array('updated_time', 'length', 'max'=>45),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, user_id, username, msisdn, description, song_count, artist_ids, on_sidebar, suggest_1, suggest_2, ivr_order, created_time, updated_time, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('song_count',$this->song_count);
		$criteria->compare('artist_ids',$this->artist_ids,true);
		$criteria->compare('on_sidebar',$this->on_sidebar);
		$criteria->compare('suggest_1',$this->suggest_1);
		$criteria->compare('suggest_2',$this->suggest_2);
		$criteria->compare('ivr_order',$this->ivr_order);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}