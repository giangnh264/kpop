<?php

class MainActiveRecord extends CActiveRecord {

    public $useMasterDb = false;

    public function onBeforeSave($event) {
        $this->useMasterDb = true;
        parent::onBeforeSave($event);
    }

    public function onAfterSave($event) {
        $this->useMasterDb = false;
        parent::onAfterSave($event);
    }

    public function onBeforeDelete($event) {
        $this->useMasterDb = true;
        parent::onBeforeDelete($event);
    }

    public function onAfterDelete($event) {
        $this->useMasterDb = false;
        parent::onAfterDelete($event);
    }

    public function getDbConnection() {
        if (!$this->useMasterDb) {
            if (isset(Yii::app()->dbslave)) {
                return Yii::app()->dbslave;
            }
        } else {
            return Yii::app()->db;
        }
        return Yii::app()->db;
    }

    /**
     * get Metadata duoc thiet lap boi Admin
     */
    function getCustomMetaData($meta_key, $index = 2) {       
        $cusData = Yii::app()->db->createCommand()
                ->select('comment,value')
                ->from('config')
                ->where('name=:name', array(':name' => $meta_key))
                ->queryRow();
        ///var_dump($cusData);
        $customData = ($index == 1) ? $cusData['comment'] : $cusData['value'];
        return $customData;
    }
    
    /**
     * lay Genre cha, Genre hot 
     * @return type 
     */
    public static function getGenre($hot = 1){
        if($hot == 1){
            $cri = new CDbCriteria;
            $cri->condition = "status = 1";
            $cri->order = "sorder ASC";
            $cri->limit = 10;
            $genres = GenreModel::model()->findAll($cri);
        }
        else{
            $cri = new CDbCriteria;
            $cri->condition = "parent_id = 0 AND status = 1";
            $cri->order = "sorder ASC";
            $genres = GenreModel::model()->findAll($cri);
        }
        return $genres;
    }
    
    public function filter_syncStatus(CDbCriteria $criteria, $table = 't') {
        //$criteria->addCondition("$table.sync_status = 1");
        return $criteria;
    }

}

?>