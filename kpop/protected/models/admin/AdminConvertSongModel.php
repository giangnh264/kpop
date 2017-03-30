<?php

Yii::import('application.models.db.ConvertSongModel');

class AdminConvertSongModel extends ConvertSongModel
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
    
    public function updateStatus($listSong,$status)
    {
    	$listProfile = AdminSongProfileModel::model()->getListPorfile();
    	
    	foreach($listSong as $song){
			$convertSong = self::model()->findByAttributes(array("song_id"=>$song));
			if(empty($convertSong)){
				$convertSong = new self();
				$convertSong->song_id = $song;
			}
			
			if(AdminSongModel::model()->findByPk($song)->source_path){
				$path = AdminSongModel::model()->findByPk($song)->source_path;
			}else{
				$path = AdminSongModel::model()->getSongOriginPath($song,false);
			}
			$convertSong->source_path = $path;
				
			$convertSong->status = $status;
			$convertSong->profile_ids = $listProfile;
			$res = $convertSong->save();
    	}
    }
}