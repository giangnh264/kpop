<?php

class UserSubscribePackageModel extends BaseUserSubscribePackageModel
{
	const ACTIVE = 1;
	const INACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribePackage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'package'=>array(self::BELONGS_TO, 'PackageModel', 'package_id', 'joinType'=>'INNER JOIN'),
		);
	}
}