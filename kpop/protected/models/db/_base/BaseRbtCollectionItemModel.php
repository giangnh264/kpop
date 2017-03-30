<?php

/**
 * This is the model class for table "rbt_collection_item".
 *
 * The followings are the available columns in table 'rbt_collection_item':
 * @property integer $id
 * @property integer $collect_id
 * @property integer $rbt_id
 * @property integer $is_hot
 * @property integer $sorder
 */
class BaseRbtCollectionItemModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtCollectionItem the static model class
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
		return 'rbt_collection_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('collect_id, rbt_id', 'required'),
			array('collect_id, rbt_id, is_hot, sorder', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, collect_id, rbt_id, is_hot, sorder', 'safe', 'on'=>'search'),
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
		$criteria->compare('collect_id',$this->collect_id);
		$criteria->compare('rbt_id',$this->rbt_id);
		$criteria->compare('is_hot',$this->is_hot);
		$criteria->compare('sorder',$this->sorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}