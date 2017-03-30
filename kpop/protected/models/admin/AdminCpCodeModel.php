<?php

Yii::import('application.models.db.CpCodeModel');

class AdminCpCodeModel extends CpCodeModel
{
	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCodeAvailable()
	{
		$c = new CDbCriteria();
		$c->condition = "cp_id =0";
		return self::model()->findAll($c);
	}
	public function updateCpCode($cpId,$code)
	{
		$cpCodeModel = self::model()->findByAttributes(array("cp_code"=>$code));
		if(!empty($cpCodeModel)){
			$cpCodeModel->cp_id = $cpId;
			$cpCodeModel->save();
		}
	}
}