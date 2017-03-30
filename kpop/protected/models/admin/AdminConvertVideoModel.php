<?php

Yii::import('application.models.db.ConvertVideoModel');

class AdminConvertVideoModel extends ConvertVideoModel
{
	const NOT_CONVERT = 0;
	const CONVERTING = 1;
	const CONVERTED = 2;
	const CONVERT_FAILD = 3;
	const DELETED = 4;
	
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function updateStatus($listVideo,$status)
    {
    	$listProfile = AdminVideoProfileModel::model()->getListPorfile();
    	
    	foreach($listVideo as $video){
			$convertVideo = self::model()->findByAttributes(array("video_id"=>$video));
			if(empty($convertVideo)){
				$convertVideo = new self();
				$convertVideo->video_id = $video;
			}
			
			if(AdminVideoModel::model()->findByPk($video)->source_path){
				$path = AdminVideoModel::model()->findByPk($video)->source_path;
			}else{
				$path = AdminVideoModel::model()->getVideoOriginPath($video,false);
			}
			$convertVideo->source_path = $path;
				
			$convertVideo->status = $status;
			$convertVideo->profile_ids = $listProfile;
			$convertVideo->save();
    	}
    }   
}