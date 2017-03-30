<?php

/**
 * This is the model class for table "favourite_video_playlist".
 *
 * The followings are the available columns in table 'favourite_video_playlist':
 * @property string $id
 * @property string $video_playlist_id
 * @property string $created_time
 * @property string $msisdn
 */
class BaseFavouriteVideoPlaylistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FavouriteVideoPlaylist the static model class
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
		return 'favourite_video_playlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_playlist_id, created_time', 'required'),
			array('video_playlist_id', 'length', 'max'=>10),
			array('msisdn', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, video_playlist_id, created_time, msisdn', 'safe', 'on'=>'search'),
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
		$criteria->compare('video_playlist_id',$this->video_playlist_id,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('msisdn',$this->msisdn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}