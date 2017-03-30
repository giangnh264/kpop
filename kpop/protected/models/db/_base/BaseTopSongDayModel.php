<?php

/**
 * This is the model class for table "top_song_day".
 *
 * The followings are the available columns in table 'top_song_day':
 * @property integer $id
 * @property string $song_id
 * @property string $song_data
 * @property string $artist_data
 * @property string $played_count
 * @property string $delta
 * @property integer $status
 */
class BaseTopSongDayModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopSongDay the static model class
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
		return 'top_song_day';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('song_data', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('song_id, played_count, delta', 'length', 'max'=>10),
			array('song_data, artist_data', 'length', 'max'=>600),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, song_id, song_data, artist_data, played_count, delta, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('song_data',$this->song_data,true);
		$criteria->compare('artist_data',$this->artist_data,true);
		$criteria->compare('played_count',$this->played_count,true);
		$criteria->compare('delta',$this->delta,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}