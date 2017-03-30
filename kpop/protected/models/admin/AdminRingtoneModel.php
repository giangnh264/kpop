<?php

Yii::import('application.models.db.RingtoneModel');

class AdminRingtoneModel extends RingtoneModel {

    const ALL = -1;
    const NOT_CONVERT = 0;
    const WAIT_APPROVED = 1;
    const ACTIVE = 2;
    const CONVERT_FAIL = 3;
    const EXPIRED = 4;
    const DELETED = 5;

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterSave() {
        if ($this->status == self::NOT_CONVERT) {
            $rtlist[] = $this->id;
            AdminConvertRingtoneModel::model()->updateStatus($rtlist, AdminConvertRingtoneModel::NOT_CONVERT);
        }
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'genre' => array(self::BELONGS_TO, 'AdminRingtoneCategoryModel', 'category_id', 'select' => 'id, name', 'joinType' => 'LEFT JOIN'),
                    'user' => array(self::BELONGS_TO, 'AdminAdminUserModel', 'created_by', 'select' => 'id, username', 'joinType' => 'LEFT JOIN'),
                    'cp' => array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select' => 'id, name', 'joinType' => 'LEFT JOIN','condition'=>'cp.status = 1'),
                    'rtstatus' => array(self::HAS_ONE, 'AdminRingtoneStatusModel', 'ringtone_id', 'joinType' => 'LEFT JOIN'),
                ));
    }

    public function getListByStatus($status, $cpId = 0) {
        $criteria = new CDbCriteria;
        $criteria->join = "INNER JOIN ringtone_status st ON t.id = st.ringtone_id";

        switch ($status) {
            case self::NOT_CONVERT:
                $criteria->condition = "st.convert_status = " . AdminRingtoneStatusModel::NOT_CONVERT;
                break;
            case self::CONVERT_FAIL:
                $criteria->condition = "st.convert_status = " . AdminRingtoneStatusModel::CONVERT_FAIL;
                break;
            case self::WAIT_APPROVED:
                $criteria->condition = "st.approve_status = " . AdminRingtoneStatusModel::WAIT_APPROVED;
                break;
            case self::ACTIVE:
                $criteria->condition = "st.approve_status = " . AdminRingtoneStatusModel::APPROVED
                        . " AND st.convert_status = " . AdminRingtoneStatusModel::CONVERT_SUCCESS;
                break;
            case self::DELETED:
                $criteria->condition = "st.approve_status = " . AdminRingtoneStatusModel::REJECT;
                break;
            case self::ALL:
            default:
                $criteria->condition = "st.approve_status <> " . AdminRingtoneStatusModel::REJECT;
                break;
        }
        if (isset($cpId) && $cpId != 0) {
            $criteria->addCondition("t.cp_id='{$cpId}'");
        }
        $criteria->order = "t.id DESC";
        return self::model()->findAll($criteria);
    }

    public function updateStatus($id, $adminId, $status) {
        $ringtone = self::model()->findByPk($id);
        $ringtone->approved_by = $adminId;
        $ringtone->updated_by = $adminId;
        $ringtone->updated_time = date("Y-m-d H:i:s");
        $ringtone->status = $status;
        $ringtone->save();
        if ($status == self::NOT_CONVERT) {
            $rtlist[] = $id;
            AdminConvertRingtoneModel::model()->updateStatus($rtlist, AdminConvertRingtoneModel::NOT_CONVERT);
        }
    }

    public function setApproved($rtList = array(), $adminId = null) {
        //UPDATE TO RINGTONE_STATUS
        $c = new CDbCriteria();
        $c->addInCondition("ringtone_id", $rtList);
        $attributes['approve_status'] = AdminRingtoneStatusModel::APPROVED;
        AdminRingtoneStatusModel::model()->updateAll($attributes, $c);

        //UPDATE TO RINGTONE
        $c = new CDbCriteria();
        $c->addInCondition("id", $rtList);
        $attributes = array('approved_by' => $adminId, 'updated_by' => $adminId, 'updated_time' => date("Y-m-d H:i:s"));
        AdminRingtoneModel::model()->updateAll($attributes, $c);
    }

    public function setdelete($adminId, $reason = "", $rtList = array()) {
        //UPDATE RINGTONE_STATUS
        $c = new CDbCriteria();
        $c->addInCondition("ringtone_id", $rtList);
        $attributes['approve_status'] = AdminRingtoneStatusModel::REJECT;
        AdminRingtoneStatusModel::model()->updateAll($attributes, $c);

        // ADD TO RINGTONE DELETE
        $rtDeleteList = AdminRingtoneDeletedModel::model()->findAll();
        $rtDeleteList = CHtml::listData($rtDeleteList, "ringtone_id", "ringtone_id");
        for ($i = 0; $i < count($rtList); $i++) {
            if (!in_array($rtList[$i], $rtDeleteList)) {
                $rtDel = new AdminRingtoneDeletedModel();
                $rtDel->ringtone_id = $rtList[$i];
                $rtDel->deleted_reason = $reason;
                $rtDel->deleted_by = $adminId;
                $rtDel->deleted_time = date("Y-m-d H:i:s");
                $rtDel->save();
            }
        }
    }

    public function restore($listRt, $adminId) {
        $conditionDelete = "ringtone_id in (" . implode(",", $listRt) . ")";
        $conditionRingtone = "id in (" . implode(",", $listRt) . ")";
        AdminRingtoneDeletedModel::model()->deleteAll($conditionDelete);
        $attr = array(
            'status' => self::NOT_CONVERT,
            'updated_by' => $adminId,
            'approved_by' => 0,
            'updated_time' => date("Y-m-d H:i:s"),
        );
        AdminRingtoneModel::model()->updateAll($attr, $conditionRingtone);
        AdminConvertRingtoneModel::model()->updateStatus($listRt, AdminConvertRingtoneModel::NOT_CONVERT);
    }

    public function setWaitApproved($rtList = array(), $adminId = null) {
        //UPDATE TO RINGTONE_STATUS
        $c = new CDbCriteria();
        $c->addInCondition("ringtone_id", $rtList);
        $attributes['approve_status'] = AdminRingtoneStatusModel::WAIT_APPROVED;
        AdminRingtoneStatusModel::model()->updateAll($attributes, $c);

        //UPDATE TO RINGTONE
        $c = new CDbCriteria();
        $c->addInCondition("id", $rtList);
        $attributes = array('approved_by' => 0, 'updated_by' => $adminId, 'updated_time' => date("Y-m-d H:i:s"));
        AdminRingtoneModel::model()->updateAll($attributes, $c);
    }

    public function setReconvert($rtList = array()) {
        //UPDATE TO RINGTONE_STATUS
        $c = new CDbCriteria();
        $c->addInCondition("ringtone_id", $rtList);
        $attributes['convert_status'] = AdminRingtoneStatusModel::NOT_CONVERT;
        $attributes['approve_status'] = AdminRingtoneStatusModel::WAIT_APPROVED;
        $row = AdminRingtoneStatusModel::model()->updateAll($attributes, $c);

        //UPDATE CONVERT_RINGNTONE
        $c = new CDbCriteria();
        $c->addInCondition("ringtone_id", $rtList);
        $attributes['status'] = AdminRingtoneStatusModel::NOT_CONVERT;
        $rowUpdate = AdminConvertRingtoneModel::model()->updateAll($attributes, $c);
        if ($rowUpdate == 0) {
            AdminConvertRingtoneModel::model()->updateStatus($rtList, AdminConvertRingtoneModel::NOT_CONVERT);
        }

        //UPDATE TO RINGTONE
        $c = new CDbCriteria();
        $c->addInCondition("id", $rtList);
        $attributes = array('approved_by' => 0, 'updated_by' => $adminId, 'updated_time' => date("Y-m-d H:i:s"));
        AdminRingtoneModel::model()->updateAll($attributes, $c);
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.category_id', $this->category_id, true);
        $criteria->compare('t.artist_id', $this->artist_id, true);
        $criteria->compare('t.artist_name', $this->artist_name, true);
        $criteria->compare('t.song_id', $this->song_id, true);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.approved_by', $this->approved_by);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.cp_id', $this->cp_id);
        $criteria->compare('t.bitrate', $this->bitrate);
        $criteria->compare('t.duration', $this->duration);
        $criteria->compare('t.price', $this->price);
        //$criteria->compare('created_time',$this->created_time,true);
        $criteria->compare('t.sorder', $this->sorder);
        //$criteria->compare('t.status',$this->status);
        $criteria->compare('sync_status', $this->sync_status);
        $criteria->compare('t.updated_time', $this->updated_time, true);

        if (!empty($this->created_time)) {
            $criteria->addBetweenCondition('t.created_time', $this->created_time[0], $this->created_time[1]);
        }

        $criteria->join = "INNER JOIN ringtone_status st ON t.id = st.ringtone_id";


        switch ($this->status) {
            case self::NOT_CONVERT:
                $condition = "st.convert_status = " . RingtoneStatusModel::NOT_CONVERT;
                break;
            case self::CONVERT_FAIL:
                $condition = "st.convert_status = " . RingtoneStatusModel::CONVERT_FAIL;
                break;
            case self::WAIT_APPROVED:
                $condition = "st.approve_status = " . RingtoneStatusModel::WAIT_APPROVED
                        . " AND st.convert_status = " . RingtoneStatusModel::CONVERT_SUCCESS;
                break;
            case self::ACTIVE:
                $condition = "st.approve_status = " . RingtoneStatusModel::APPROVED
                        . " AND st.convert_status = " . RingtoneStatusModel::CONVERT_SUCCESS;
                break;
            case self::DELETED:
                $condition = "st.approve_status = " . RingtoneStatusModel::REJECT;
                break;
            case self::ALL:
            default:
                $condition = "st.approve_status <> " . RingtoneStatusModel::REJECT;
                break;
        }
        $criteria->addCondition($condition);
        $criteria->with = array('genre', 'cp');

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array('defaultOrder' => 't.id DESC'),
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

}