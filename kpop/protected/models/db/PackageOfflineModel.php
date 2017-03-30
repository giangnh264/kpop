<?php

class PackageOfflineModel extends BasePackageOfflineModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return PackageOffline the static model class
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
			)
		);
	}
}