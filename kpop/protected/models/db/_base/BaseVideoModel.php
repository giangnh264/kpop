<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property integer $id
 * @property string $old_id
 * @property integer $code
 * @property string $name
 * @property string $url_key
 * @property string $song_id
 * @property integer $genre_id
 * @property string $composer_id
 * @property string $artist_name
 * @property string $owner
 * @property string $source
 * @property string $source_link
 * @property string $national
 * @property string $language
 * @property integer $created_by
 * @property integer $approved_by
 * @property integer $updated_by
 * @property integer $cp_id
 * @property string $source_path
 * @property integer $allow_download
 * @property double $download_price
 * @property double $listen_price
 * @property integer $duration
 * @property integer $max_bitrate
 * @property string $profile_ids
 * @property integer $suggest_1
 * @property integer $suggest_2
 * @property integer $is_new
 * @property integer $is_exclusive
 * @property string $created_time
 * @property string $updated_time
 * @property string $copyright
 * @property string $related_right
 * @property string $active_fromtime
 * @property string $active_totime
 * @property integer $sorder
 * @property integer $status
 * @property integer $sync_status
 * @property integer $custom_rank
 * @property integer $onlyone
 * @property string $cmc_id
 */
class BaseVideoModel extends MainContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Video the static model class
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
		return 'video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, url_key, artist_name', 'required'),
			array('code, genre_id, created_by, approved_by, updated_by, cp_id, allow_download, duration, max_bitrate, suggest_1, suggest_2, is_new, is_exclusive, sorder, status, sync_status, custom_rank, onlyone', 'numerical', 'integerOnly'=>true),
			array('download_price, listen_price', 'numerical'),
			array('old_id, song_id, composer_id', 'length', 'max'=>10),
			array('name, url_key, owner, source, source_link, national, source_path, profile_ids', 'length', 'max'=>255),
			array('artist_name', 'length', 'max'=>64),
			array('language', 'length', 'max'=>45),
			array('copyright, related_right', 'length', 'max'=>11),
			array('cmc_id', 'length', 'max'=>20),
			array('created_time, updated_time, active_fromtime, active_totime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_id, code, name, url_key, song_id, genre_id, composer_id, artist_name, owner, source, source_link, national, language, created_by, approved_by, updated_by, cp_id, source_path, allow_download, download_price, listen_price, duration, max_bitrate, profile_ids, suggest_1, suggest_2, is_new, is_exclusive, created_time, updated_time, copyright, related_right, active_fromtime, active_totime, sorder, status, sync_status, custom_rank, onlyone, cmc_id', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('old_id',$this->old_id,true);
		$criteria->compare('code',$this->code);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('composer_id',$this->composer_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('source_link',$this->source_link,true);
		$criteria->compare('national',$this->national,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('source_path',$this->source_path,true);
		$criteria->compare('allow_download',$this->allow_download);
		$criteria->compare('download_price',$this->download_price);
		$criteria->compare('listen_price',$this->listen_price);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('max_bitrate',$this->max_bitrate);
		$criteria->compare('profile_ids',$this->profile_ids,true);
		$criteria->compare('suggest_1',$this->suggest_1);
		$criteria->compare('suggest_2',$this->suggest_2);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('is_exclusive',$this->is_exclusive);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('copyright',$this->copyright,true);
		$criteria->compare('related_right',$this->related_right,true);
		$criteria->compare('active_fromtime',$this->active_fromtime,true);
		$criteria->compare('active_totime',$this->active_totime,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('sync_status',$this->sync_status);
		$criteria->compare('custom_rank',$this->custom_rank);
		$criteria->compare('onlyone',$this->onlyone);
		$criteria->compare('cmc_id',$this->cmc_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}