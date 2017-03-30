<?php

class VasStatusSyncFileModel extends BaseVasStatusSyncFileModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VasStatusSyncFile the static model class
	 */

    const ACTIVE = 1;
    const INACTIVE = 0;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}