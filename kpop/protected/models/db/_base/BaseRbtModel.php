<?php

/**
 * This is the model class for table "rbt".
 *
 * The followings are the available columns in table 'rbt':
 * @property integer $id
 * @property string $code
 * @property string $name_song
 * @property string $name_singer
 * @property string $price
 * @property string $start_day
 * @property string $end_day
 * @property string $link_listen_web
 * @property string $link_listen_wap3g
 */
class BaseRbtModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Rbt the static model class
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
		return 'rbt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, code, name_song', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('code, start_day, end_day', 'length', 'max'=>100),
			array('name_song, link_listen_web, link_listen_wap3g', 'length', 'max'=>255),
			array('name_singer', 'length', 'max'=>150),
			array('price', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name_song, name_singer, price, start_day, end_day, link_listen_web, link_listen_wap3g', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name_song',$this->name_song,true);
		$criteria->compare('name_singer',$this->name_singer,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('start_day',$this->start_day,true);
		$criteria->compare('end_day',$this->end_day,true);
		$criteria->compare('link_listen_web',$this->link_listen_web,true);
		$criteria->compare('link_listen_wap3g',$this->link_listen_wap3g,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}