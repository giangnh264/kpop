<?php

/**
 * This is the model class for table "api_object".
 *
 * The followings are the available columns in table 'api_object':
 * @property string $object_id
 * @property integer $api_id
 * @property string $title
 * @property string $description
 * @property string $thumb_url
 * @property string $link
 * @property integer $total_download
 * @property integer $total_play
 * @property string $custom_field
 */
class BaseApiObjectModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ApiObject the static model class
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
		return 'api_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('api_id, title, description, thumb_url, link', 'required'),
			array('api_id, total_download, total_play', 'numerical', 'integerOnly'=>true),
			array('object_id', 'length', 'max'=>50),
			array('title, thumb_url, link', 'length', 'max'=>255),
			array('custom_field', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('object_id, api_id, title, description, thumb_url, link, total_download, total_play, custom_field', 'safe', 'on'=>'search'),
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

		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('api_id',$this->api_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('thumb_url',$this->thumb_url,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('total_download',$this->total_download);
		$criteria->compare('total_play',$this->total_play);
		$criteria->compare('custom_field',$this->custom_field,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}