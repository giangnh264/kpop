<?php

Yii::import('application.models.db.CopyrightModel');

class AdminCopyrightModel extends CopyrightModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getListMap()
    {
    	$return = array();
    	$data = self::model()->findAll();
    	#echo "<pre>";print_r(json_decode(CJSON::encode($ddd)));exit();
    	foreach($data as $item){
    		$return[$item->id]  = json_decode(CJSON::encode($item),true);
    	}
    	return $return;
    }
}