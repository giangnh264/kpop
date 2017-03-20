<?php

Yii::import('application.models.db.PackageModel');

class BmPackageModel extends PackageModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function scopes() {
		return array(
			'published'=>array(
                'condition' => 'status = '.PackageModel::ACTIVE,
            ),
        );
	}
	public function get($package) {
		$criteria = new CDbCriteria();
		$criteria->condition='code = :CODE';
		$criteria->params=array(':CODE'=>$package);
		return self::model()->published()->find($criteria);
	}
	public function getById($packageId) {
		$criteria = new CDbCriteria();
		$criteria->condition='id = :ID';
		$criteria->params=array(':ID' => $packageId);
		return self::model()->published()->find($criteria);
	}
	
}