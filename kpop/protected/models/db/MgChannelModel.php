<?php

class MgChannelModel extends BaseMgChannelModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MgChannel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function defaultScope()
	{
		return array(
				'condition' => 't.status = 1',
		);
	}
}