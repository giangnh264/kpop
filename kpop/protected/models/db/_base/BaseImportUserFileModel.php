<?php

/**
 * This is the model class for table "import_user_file".
 *
 * The followings are the available columns in table 'import_user_file':
 * @property integer $id
 * @property string $file_name
 * @property string $file_path
 * @property integer $created_by
 * @property string $created_time
 * @property string $content_type
 * @property integer $package_id
 */
class BaseImportUserFileModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImportUserFile the static model class
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
		return 'import_user_file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_by, package_id', 'numerical', 'integerOnly'=>true),
			array('file_name, file_path', 'length', 'max'=>255),
			array('content_type', 'length', 'max'=>11),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, file_name, file_path, created_by, created_time, content_type, package_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_path',$this->file_path,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('package_id',$this->package_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}