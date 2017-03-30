<?php

/**
 * This is the model class for table "store_cat_map".
 *
 * The followings are the available columns in table 'store_cat_map':
 * @property integer $id
 * @property string $zing_catname_parent
 * @property string $zing_catname
 * @property string $chacha_catname_parent
 * @property string $chacha_catname
 * @property integer $chacha_cat_id
 */
class BaseStoreCatMapModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreCatMap the static model class
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
		return 'store_cat_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chacha_cat_id', 'numerical', 'integerOnly'=>true),
			array('zing_catname_parent, zing_catname, chacha_catname_parent, chacha_catname', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, zing_catname_parent, zing_catname, chacha_catname_parent, chacha_catname, chacha_cat_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('zing_catname_parent',$this->zing_catname_parent,true);
		$criteria->compare('zing_catname',$this->zing_catname,true);
		$criteria->compare('chacha_catname_parent',$this->chacha_catname_parent,true);
		$criteria->compare('chacha_catname',$this->chacha_catname,true);
		$criteria->compare('chacha_cat_id',$this->chacha_cat_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}