<?php
class RingtoneModel extends BaseRingtoneModel {

    const ALL = -1;
    const ACTIVE = 1;

    //const DEACTIVE = 0;
    /**
     * Returns the static model of the specified AR class.
     * @return Ringtone the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            "ringtone_statistic" => array(self::HAS_ONE, "RingtoneStatisticModel", "ringtone_id"),
		);
	}

    public function getRingtoneOriginPath($id = null, $isFullPath = true) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp3";
        if ($isFullPath)
            return $path = Yii::app()->params['storage']['ringtoneDir'] . DS . "origin" . DS . $savePath;
        else
            return $savePath;
    }

    public function getRingtoneOriginUrl($id = null) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp3";
        $path = Yii::app()->params['storage']['ringtoneUrl'] . "origin/" . $savePath;
        return $path;
    }

    public function getAudioFilePath($id = null, $isFullPath = true) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp3";
        if ($isFullPath){
            $mediaPath = Common::getMediaPath($id,'ringtone');
	        if($mediaPath){
	        	$mediaPath = $mediaPath."/";
	        }
            return $path = Yii::app()->params['storage']['baseStorage'].$mediaPath. "ringtones/mp3" . DS . $savePath;        	
        }
        else
            return $savePath;
    }

    public function getAudioFileUrl($id = null) {
        if (!isset($id))
            $id = $this->id;
        $savePath = Common::storageSolutionEncode($id) . $id . ".mp3";
        $mediaPath = Common::getMediaPath($id,'ringtone');
        if($mediaPath){
        	$mediaPath = $mediaPath."/";
        }
        $path = Yii::app()->params['storage']['ringtoneUrl'] .$mediaPath. "ringtones/mp3/" . $savePath;
        return $path;
    }
    
    public function findAllByIds($ids) {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $ids);
        return $this->findAll($criteria);
    }

}