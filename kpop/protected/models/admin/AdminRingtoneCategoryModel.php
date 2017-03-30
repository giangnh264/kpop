<?php

Yii::import('application.models.db.RingtoneCategoryModel');

class AdminRingtoneCategoryModel extends RingtoneCategoryModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    protected function beforeSave() {
    	if(!$this->url_key) $this->url_key = Common::url_friendly($this->name);
    	return parent::beforeSave();
    }

    

    public function gettreelist($type = 1, $limit = false, $offset = 0) {
        $cmd = Yii::app()->db->createCommand()
                ->select('*')
                ->from(self::tableName())
                ->order("parent_id ASC, sorder ASC ");
        if ($limit) {
            $cmd->limit($limit)->offset($offset);
        }
        $data = $cmd->queryAll();
        $option = array(
            'parend_id' => 'parent_id',
            'name' => 'name',
            'primary' => 'id',
            'type' => $type,
        );
        $treeObj = new TreeList($data, $option);
        return $treeObj->getTreeList();
    }

}