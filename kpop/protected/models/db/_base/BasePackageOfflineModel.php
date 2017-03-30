<?php

/**
 * This is the model class for table "package_offline".
 *
 * The followings are the available columns in table 'package_offline':
 * @property integer $id
 * @property string $code
 * @property string $package_code
 * @property integer $status
 * @property string $admin_user
 */
class BasePackageOfflineModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PackageOffline the static model class
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
		return 'package_offline';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('code, package_code', 'length', 'max'=>50),
			array('admin_user', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, package_code, status, admin_user', 'safe', 'on'=>'search'),
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
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'package_code' => 'Package Code',
			'status' => 'Status',
			'admin_user' => 'Admin User',
		);
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
		$criteria->compare('package_code',$this->package_code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('admin_user',$this->admin_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
} 