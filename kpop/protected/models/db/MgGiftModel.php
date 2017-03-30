<?php
class MgGiftModel extends BaseMgGiftModel {

    const ACTIVE = 0;// qua chua gui
    const DEACTIVE = 1;// qua da gui roi

    /**
     * Returns the static model of the specified AR class.
     * @return MgGift the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function relations()
    {
    	return  CMap::mergeArray( parent::relations(),   array(
    			'msg'=>array(self::HAS_ONE, 'MgMessageModel', 'gift_id', 'joinType'=>'LEFT JOIN'),
    	));
    }
}