<?php

/**
 * This is the model class for table "rbt_ringtune".
 *
 * The followings are the available columns in table 'rbt_ringtune':
 * @property string $id
 * @property string $content_id
 * @property string $content_lang
 * @property string $content_type
 * @property string $content_title
 * @property string $content_artist
 * @property string $length
 * @property integer $billing_category
 * @property string $billing_desc
 * @property string $content_owner
 * @property string $in_mylist
 * @property integer $mo_id
 * @property integer $expiration
 * @property string $path
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_path
 * @property string $updated_datetime
 */
class BaseRbtRingtuneModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtRingtune the static model class
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
		return 'rbt_ringtune';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('billing_category, mo_id, expiration, category_id', 'numerical', 'integerOnly'=>true),
			array('content_id', 'length', 'max'=>11),
			array('content_lang', 'length', 'max'=>10),
			array('content_type, length, in_mylist', 'length', 'max'=>5),
			array('content_title, path, category_path', 'length', 'max'=>255),
			array('content_artist, billing_desc, content_owner, category_name', 'length', 'max'=>100),
			array('updated_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content_id, content_lang, content_type, content_title, content_artist, length, billing_category, billing_desc, content_owner, in_mylist, mo_id, expiration, path, category_id, category_name, category_path, updated_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('content_lang',$this->content_lang,true);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('content_title',$this->content_title,true);
		$criteria->compare('content_artist',$this->content_artist,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('billing_category',$this->billing_category);
		$criteria->compare('billing_desc',$this->billing_desc,true);
		$criteria->compare('content_owner',$this->content_owner,true);
		$criteria->compare('in_mylist',$this->in_mylist,true);
		$criteria->compare('mo_id',$this->mo_id);
		$criteria->compare('expiration',$this->expiration);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('category_path',$this->category_path,true);
		$criteria->compare('updated_datetime',$this->updated_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}