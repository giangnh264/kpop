<?php

/**
 * This is the model class for table "suggest".
 *
 * The followings are the available columns in table 'suggest':
 * @property string $id
 * @property string $name
 * @property string $genre_id
 * @property string $artist_id
 * @property string $host_name
 * @property integer $auto_redirect
 * @property string $description
 * @property integer $status
 */
class BaseSuggestModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Suggest the static model class
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
		return 'suggest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('auto_redirect, status', 'numerical', 'integerOnly'=>true),
			array('name, genre_id, artist_id, description', 'length', 'max'=>255),
			array('host_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, genre_id, artist_id, host_name, auto_redirect, description, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('genre_id',$this->genre_id,true);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('host_name',$this->host_name,true);
		$criteria->compare('auto_redirect',$this->auto_redirect);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}