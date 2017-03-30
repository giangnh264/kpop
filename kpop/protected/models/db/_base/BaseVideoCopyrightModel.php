<?php

/**
 * This is the model class for table "video_copyright".
 *
 * The followings are the available columns in table 'video_copyright':
 * @property integer $id
 * @property string $video_id
 * @property integer $copryright_id
 * @property integer $type
 * @property string $from_date
 * @property string $due_date
 * @property string $sorder
 */
class BaseVideoCopyrightModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoCopyright the static model class
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
		return 'video_copyright';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_id, copryright_id, type', 'required'),
			array('copryright_id, type', 'numerical', 'integerOnly'=>true),
			array('video_id, sorder', 'length', 'max'=>10),
			array('from_date, due_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, video_id, copryright_id, type, from_date, due_date, sorder', 'safe', 'on'=>'search'),
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
		$criteria->compare('video_id',$this->video_id,true);
		$criteria->compare('copryright_id',$this->copryright_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('sorder',$this->sorder,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}