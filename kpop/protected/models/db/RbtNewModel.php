<?php
class RbtNewModel extends BaseRbtNewModel {
    const ACTIVE = 1;
    const DEACTIVE = 0;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}