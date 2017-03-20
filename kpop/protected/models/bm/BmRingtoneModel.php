<?php

Yii::import('application.models.db.RingtoneModel');

class BmRingtoneModel extends RingtoneModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function scopes() {
		return array(
			'published'=>array(
                'condition' => 't.status = '.self::ACTIVE
			),
        );
	}

	public function getRingtoneByCode($code) {
		$criteria = new CDbCriteria();
		$criteria->condition = "code = :CODE";
		$criteria->params = array(
			':CODE' => $code,
		);
		return self::model()->published()->find($criteria);
	}

}