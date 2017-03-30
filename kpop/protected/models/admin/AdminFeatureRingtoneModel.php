<?php

Yii::import('application.models.db.FeatureRingtoneModel');

class AdminFeatureRingtoneModel extends FeatureRingtoneModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
     

    public function addList($adminId, $listRbt = array()) {
        //get all rt feature
        $rtFeature = self::model()->findAll();
        $rtFeature = CHtml::listData($rtFeature, 'rt_id', 'rt_id');

        $c = new CDbCriteria();
        $c->condition = "status = " . RingtoneModel::ACTIVE;
        $c->addInCondition("id", $listRbt);
        $c->addNotInCondition("id", $rtFeature);
        $rtAdding = AdminRingtoneModel::model()->findAll($c);
        foreach ($rtAdding as $rt) {
            $model = new self();
            $model->rt_id = $rt->id;
            $model->created_by = $adminId;
            $model->created_time = date("Y-m-d H:i:s");
            $model->save();
        }
    }

}