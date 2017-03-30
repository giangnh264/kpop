<?php
/**
 * This is the model class for table "encode_audio_output".
 *
 * The followings are the available columns in table 'encode_audio_output':
 * @property string $id
 * @property string $input_id
 * @property string $output_id
 * @property integer $profile_id
 * @property string $url
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
class BaseEncodeAudioOutputModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EncodeAudioOutput the static model class
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
		return 'encode_audio_output';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profile_id, audio_bitrate, audio_channels, audio_sample_rate, duration, filesize', 'numerical', 'integerOnly'=>true),
			array('input_id, output_id, current_event, status', 'length', 'max'=>20),
			array('url', 'length', 'max'=>255),
			array('audio_codec, format', 'length', 'max'=>6),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, input_id, output_id, profile_id, url, audio_bitrate, audio_channels, audio_codec, audio_sample_rate, duration, filesize, format, created_time, updated_time, current_event, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('input_id',$this->input_id,true);
		$criteria->compare('output_id',$this->output_id,true);
		$criteria->compare('profile_id',$this->profile_id);
		$criteria->compare('url',$this->url,true);
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