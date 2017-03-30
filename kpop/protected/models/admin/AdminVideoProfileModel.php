<?php

Yii::import('application.models.db.VideoProfileModel');

class AdminVideoProfileModel extends VideoProfileModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getListPorfile()
    {
    	$sql = "SELECT GROUP_CONCAT(profile_id) AS listProfile FROM video_profile";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		return $data['listProfile'];
    }
}