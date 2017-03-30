<?php

/**
 * This is the model class for table "feature_album".
 *
 * The followings are the available columns in table 'feature_album':
 * @property integer $id
 * @property integer $album_id
 * @property integer $created_by
 * @property string $created_time
 * @property integer $sorder
 * @property integer $status
 * @property integer $featured
 */
class BaseFeatureAlbumModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FeatureAlbum the static model class
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
		return 'feature_album';
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
			array('album_id, created_by, sorder, status, featured', 'numerical', 'integerOnly'=>true),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_id, created_by, created_time, sorder, status, featured', 'safe', 'on'=>'search'),
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
		$criteria->compare('album_id',$this->album_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('featured',$this->featured);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}