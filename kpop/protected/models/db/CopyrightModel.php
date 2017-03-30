<?php

class CopyrightModel extends BaseCopyrightModel {

    /**
     * Returns the static model of the specified AR class.
     * @return Copyright the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'ccP' => array(self::BELONGS_TO, 'AdminCcpModel', 'ccp', 'select' => 'id, name', 'joinType' => 'LEFT JOIN'),
        ));
    }

}