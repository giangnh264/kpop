<?php

class AdsSourceModel extends BaseAdsSourceModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	const DELETED = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdsSource the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function scopes()
	{
		return array(
				"published" => array(
                	"condition" => "t.status = " . self::ACTIVE,
            	),
				"deleted" => array(
					"condition" => "t.status = " . self::DELETED,
				)
		);
	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'checkUnique'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description, created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, created_datetime, status', 'safe', 'on'=>'search'),
		);
	}
	public function checkUnique()
	{
		if($this->isNewRecord){
			$ads = self::model()->findByAttributes(array('name'=>$this->name));
			if($ads)
				$this->addError("name","Đã tồn tại mã quảng cáo <strong>{$this->name}</strong>");
		}
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('status',$this->status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
				),
		));
	}
}