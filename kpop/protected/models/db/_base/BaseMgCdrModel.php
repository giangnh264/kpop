<?php

/**
 * This is the model class for table "mg_cdr".
 *
 * The followings are the available columns in table 'mg_cdr':
 * @property string $id
 * @property string $calldate
 * @property string $clid
 * @property string $src
 * @property string $dst
 * @property string $dcontext
 * @property string $channel
 * @property string $dstchannel
 * @property string $lastapp
 * @property string $lastdata
 * @property integer $duration
 * @property integer $billsec
 * @property string $disposition
 * @property string $amaflags
 * @property string $accountcode
 * @property string $userfield
 * @property string $uniqueid
 * @property integer $gift_id
 */
class BaseMgCdrModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MgCdr the static model class
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
		return 'mg_cdr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('calldate', 'required'),
			array('duration, billsec, gift_id', 'numerical', 'integerOnly'=>true),
			array('clid, src, dst, dcontext, lastapp, lastdata, disposition, amaflags, accountcode, userfield', 'length', 'max'=>255),
			array('channel, dstchannel', 'length', 'max'=>20),
			array('uniqueid', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, calldate, clid, src, dst, dcontext, channel, dstchannel, lastapp, lastdata, duration, billsec, disposition, amaflags, accountcode, userfield, uniqueid, gift_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('calldate',$this->calldate,true);
		$criteria->compare('clid',$this->clid,true);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('dst',$this->dst,true);
		$criteria->compare('dcontext',$this->dcontext,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('dstchannel',$this->dstchannel,true);
		$criteria->compare('lastapp',$this->lastapp,true);
		$criteria->compare('lastdata',$this->lastdata,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('billsec',$this->billsec);
		$criteria->compare('disposition',$this->disposition,true);
		$criteria->compare('amaflags',$this->amaflags,true);
		$criteria->compare('accountcode',$this->accountcode,true);
		$criteria->compare('userfield',$this->userfield,true);
		$criteria->compare('uniqueid',$this->uniqueid,true);
		$criteria->compare('gift_id',$this->gift_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}