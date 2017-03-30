<?php

/**
 * This is the model class for table "shortlink_logs".
 *
 * The followings are the available columns in table 'shortlink_logs':
 * @property string $id
 * @property integer $link_id
 * @property string $user_ip
 * @property string $msisdn
 * @property string $user_agent
 * @property string $referer
 * @property string $package
 * @property string $loged_datetime
 */
class BaseShortlinkLogsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ShortlinkLogs the static model class
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
		return 'shortlink_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link_id', 'numerical', 'integerOnly'=>true),
			array('user_ip', 'length', 'max'=>50),
			array('msisdn', 'length', 'max'=>20),
			array('user_agent', 'length', 'max'=>400),
			array('referer', 'length', 'max'=>255),
			array('package', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, link_id, user_ip, msisdn, user_agent, referer, package, loged_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('referer',$this->referer,true);
		$criteria->compare('package',$this->package,true);
		$criteria->compare('loged_datetime',$this->loged_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}