<?php
class RbtCollectionItemModel extends BaseRbtCollectionItemModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RbtCollectionItem the static model class
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
			'rbt'=>array(self::BELONGS_TO, 'RbtModel', 'rbt_id'),
		);
	}
}