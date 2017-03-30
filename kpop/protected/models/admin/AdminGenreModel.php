<?php

Yii::import('application.models.db.GenreModel');

class AdminGenreModel extends GenreModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if (!$this->url_key)
            $this->url_key = Common::url_friendly($this->name);
        if (!$this->updated_time)
            $this->updated_time = date("Y-m-d H:i:s");
        return parent::beforeSave();
    }

    public function gettreelist($type = 1, $limit = false, $offset = 0, $with_collection = 1, $isFull = false, $genreType='') {
        if($with_collection == 0)
            $where = " is_collection = 0";
        else
            $where = " 1 = 1";
        if(!$isFull){
        	$where .= " AND status = 1";
        }
        if(!empty($genreType)){
        	if($genreType=='all'){
        		$where .=" AND TRUE ";
        	}else{
        		$where .=" AND (type=:type OR type='all') ";
        	}
        }else{
        	$where .=" AND true ";
        }
        $cmd = Yii::app()->db->createCommand()
                ->select('*')
                ->from(self::tableName())
                ->where($where, array(':type'=>$genreType))
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