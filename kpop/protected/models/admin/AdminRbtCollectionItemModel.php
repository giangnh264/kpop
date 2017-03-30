<?php

Yii::import('application.models.db.RbtCollectionItemModel');

class AdminRbtCollectionItemModel extends RbtCollectionItemModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function addList($groupId, $listRbt = array()) {
        //get all rbt feature
//		$rbtCollectionItem = self::model()->findAll();
//		$rbtCollectionItem = CHtml::listData($rbtCollectionItem,'rbt_id','rbt_id');
//		
//		$c = new CDbCriteria();
//		$c->condition = "status = ".RbtModel::ACTIVE;
//		$c->addInCondition("id", $listRbt);
//		$c->addNotInCondition("id", $rbtCollectionItem);
//		$rbtAdding = AdminRbtModel::model()->findAll($c);
//		foreach($rbtAdding as $rbt){
//				$model = new self();
//				$model->rbt_id = $rbt->id;
//				$model->created_by = $adminId;
//				$model->created_time = date("Y-m-d H:i:s");
//				$model->save();
//		}
        foreach ($listRbt as $rbtId) {

            $exist = AdminRbtCollectionItemModel::model()->exists('collect_id = :collect_id AND rbt_id= :rbt_id', array(':rbt_id' => $rbtId, ':collect_id' => $id));
            if ($exist == false) {
                $model = new self();
                $model->rbt_id = $rbtId;
                $model->collect_id = $groupId;
                $model->is_hot = 0;
                $model->sorder = 0;
                $model->save();
            }
        }
    }

}