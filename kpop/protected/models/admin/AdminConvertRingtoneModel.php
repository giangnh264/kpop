<?php

Yii::import('application.models.db.ConvertRingtoneModel');

class AdminConvertRingtoneModel extends ConvertRingtoneModel
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
    
    public function updateStatus($listRingtone,$status)
    {
    	foreach($listRingtone as $rt){
			$convertRingtone = self::model()->findByAttributes(array("ringtone_id"=>$rt));
			if(empty($convertRingtone)){
				$convertRingtone = new self();
				$convertRingtone->ringtone_id = $rt;
				$convertRingtone->source_path = AdminRingtoneModel::model()->getRingtoneOriginPath($rt,false);
			}
			$convertRingtone->status = $status;
			$convertRingtone->save();
    	}
    }    

    
}