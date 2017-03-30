<?php
/**
 * This is the model class for table "encode_audio_input".
 *
 * The followings are the available columns in table 'encode_audio_input':
 * @property string $id
 * @property string $item_id
 * @property string $item_type
 * @property string $url
 * @property string $profile_ids
 * @property string $input_id
 * @property integer $audio_bitrate
 * @property integer $audio_channels
 * @property string $audio_codec
 * @property integer $audio_sample_rate
 * @property integer $duration
 * @property integer $filesize
 * @property string $format
 * @property string $created_time
 * @property string $updated_time
 * @property string $current_event
 * @property string $status
 */
class BaseEncodeAudioInputModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EncodeAudioInput the static model class
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
		return 'encode_audio_input';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id', 'required'),
			array('audio_bitrate, audio_channels, audio_sample_rate, duration, filesize', 'numerical', 'integerOnly'=>true),
			array('item_id, input_id, current_event, status', 'length', 'max'=>20),
			array('item_type', 'length', 'max'=>10),
			array('url', 'length', 'max'=>255),
			array('profile_ids', 'length', 'max'=>45),
			array('audio_codec, format', 'length', 'max'=>6),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, item_type, url, profile_ids, input_id, audio_bitrate, audio_channels, audio_codec, audio_sample_rate, duration, filesize, format, created_time, updated_time, current_event, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('item_type',$this->item_type,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('profile_ids',$this->profile_ids,true);
		$criteria->compare('input_id',$this->input_id,true);
		$criteria->compare('audio_bitrate',$this->audio_bitrate);
		$criteria->compare('audio_channels',$this->audio_channels);
		$criteria->compare('audio_codec',$this->audio_codec,true);
		$criteria->compare('audio_sample_rate',$this->audio_sample_rate);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('filesize',$this->filesize);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('current_event',$this->current_event,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}