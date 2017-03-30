<?php
class RingtoneCategoryModel extends BaseRingtoneCategoryModel {
    /**
     * Returns the static model of the specified AR class.
     * @return RingtoneCategory the static model class
     */

    const ACTIVE = 1;
    const DEACTIVE = 0;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}