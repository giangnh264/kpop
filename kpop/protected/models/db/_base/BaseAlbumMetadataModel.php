<?php

/**
 * This is the model class for table "album_metadata".
 *
 * The followings are the available columns in table 'album_metadata':
 * @property string $album_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class BaseAlbumMetadataModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AlbumMetadata the static model class
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
		return 'album_metadata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_id', 'required'),
			array('album_id', 'length', 'max'=>10),
			array('title, keywords', 'length', 'max'=>255),
			array('description', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('album_id, title, keywords, description', 'safe', 'on'=>'search'),
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

		$criteria->compare('album_id',$this->album_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}