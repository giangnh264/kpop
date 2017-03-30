<?php

/**
 * This is the model class for table "song_old".
 *
 * The followings are the available columns in table 'song_old':
 * @property string $id
 * @property integer $code
 * @property integer $group_id
 * @property string $name
 * @property string $url_key
 * @property integer $genre_id
 * @property integer $composer_id
 * @property integer $singer_id
 * @property string $singer_name
 * @property string $lyrics
 * @property integer $mp3_duration
 * @property integer $max_bitrate
 * @property integer $admin_upload_id
 * @property integer $approved_by
 * @property integer $updated_by
 * @property string $cp_id
 * @property string $source_path
 * @property integer $download_price
 * @property integer $listen_price
 * @property integer $total_play
 * @property integer $total_download
 * @property string $created_datetime
 * @property string $updated_time
 * @property integer $approved
 * @property integer $status
 * @property integer $migrated
 * @property integer $migrated_times
 */
class BaseSongOldModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongOld the static model class
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
		return 'song_old';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, group_id, genre_id, composer_id, singer_id, mp3_duration, max_bitrate, admin_upload_id, approved_by, updated_by, download_price, listen_price, total_play, total_download, approved, status, migrated, migrated_times', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('name, singer_name', 'length', 'max'=>160),
			array('cp_id', 'length', 'max'=>11),
			array('url_key, lyrics, source_path, created_datetime, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, group_id, name, url_key, genre_id, composer_id, singer_id, singer_name, lyrics, mp3_duration, max_bitrate, admin_upload_id, approved_by, updated_by, cp_id, source_path, download_price, listen_price, total_play, total_download, created_datetime, updated_time, approved, status, migrated, migrated_times', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('composer_id',$this->composer_id);
		$criteria->compare('singer_id',$this->singer_id);
		$criteria->compare('singer_name',$this->singer_name,true);
		$criteria->compare('lyrics',$this->lyrics,true);
		$criteria->compare('mp3_duration',$this->mp3_duration);
		$criteria->compare('max_bitrate',$this->max_bitrate);
		$criteria->compare('admin_upload_id',$this->admin_upload_id);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('cp_id',$this->cp_id,true);
		$criteria->compare('source_path',$this->source_path,true);
		$criteria->compare('download_price',$this->download_price);
		$criteria->compare('listen_price',$this->listen_price);
		$criteria->compare('total_play',$this->total_play);
		$criteria->compare('total_download',$this->total_download);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('status',$this->status);
		$criteria->compare('migrated',$this->migrated);
		$criteria->compare('migrated_times',$this->migrated_times);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}