<?php

/**
 * This is the model class for table "solr_rbt".
 *
 * The followings are the available columns in table 'solr_rbt':
 * @property string $type
 * @property string $id
 * @property string $name
 * @property integer $code
 * @property string $artist_id
 * @property string $artist_name
 * @property integer $category_id
 * @property string $category_name
 * @property double $price
 * @property string $updated_time
 */
class BaseSolrRbtModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SolrRbt the static model class
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
		return 'solr_rbt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, artist_id, artist_name, category_id, updated_time', 'required'),
			array('code, category_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('type', 'length', 'max'=>3),
			array('id', 'length', 'max'=>14),
			array('name, artist_name, category_name', 'length', 'max'=>160),
			array('artist_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type, id, name, code, artist_id, artist_name, category_id, category_name, price, updated_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('type',$this->type,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}