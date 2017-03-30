<?php

class PushNotifSettingModel extends BasePushNotifSettingModel {

    /**
     * Returns the static model of the specified AR class.
     * @return PushNotifSetting the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('device_os', $this->device_os, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('timesend', $this->timesend, true);
        $criteria->compare('group', $this->group);
        $criteria->compare('status', $this->status);
        $criteria->order = "id desc";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

}