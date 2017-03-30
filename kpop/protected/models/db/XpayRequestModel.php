<?php

class XpayRequestModel extends BaseXpayRequestModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return XpayRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getRequest($limit, $offset){
        $cr = new CDbCriteria();
        $cr->condition = 'request_status = :REQUEST_STT';
        $cr->params = array(':REQUEST_STT'=>0);
        $cr->limit = $limit;
        $cr->offset = $offset;
        $cr->order = 'id ASC';

        return self::model()->findAll($cr);
    }

}