<?php

class AdsMarketingModel extends BaseAdsMarketingModel
{
	const ACTIVE=1;
	const DEACTIVE=0;
	const DELETED=2;
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdsMarketing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}