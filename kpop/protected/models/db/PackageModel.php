<?php
class PackageModel extends BasePackageModel
{
	const ACTIVE = 1;
	const DEACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Package the static model class
	 */
	public function scopes() {
		return array(
			'published' => array(
				'condition' => 't.status = ' . self::ACTIVE,
			),
		);
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}