<?php
class MetadataModel extends BaseMetadataModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Metadata the static model class
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
		return 'metadata';
	}
}