<?php

class ApiObjectModel extends BaseApiObjectModel
{
	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'source'=>array(self::BELONGS_TO, 'WapApiSourceModel', 'api_id'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return ApiObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}