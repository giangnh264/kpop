<?php

Yii::import('application.models.db.ApproveSessionModel');

class AdminApproveSessionModel extends ApproveSessionModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function contentCheckout($objType, $contentId)
    {
		$c =  new CDbCriteria();
		$c->condition = "obj_type=:TYPE AND obj_id=:ID";
		$c->params = array(":TYPE"=>$objType,":ID"=>$contentId);
		$checkout = self::model()->find($c);
    	return $checkout;
    }
        
    public function addSession($objectType,$objectId,$adminId)
    {
    	$session = new self();
    	$session->obj_type = $objectType;
		$session->obj_id = $objectId;
		$session->admin_id = $adminId;
		$session->created_time = date("Y-m-d H:i:s");
		$session->save();
    }
    
    public function removeSession($objType,$adminId)
    {
		$c =  new CDbCriteria;
        $c->condition = "obj_type=:TYPE  AND admin_id=:UID" ;
        $c->params = array(":TYPE"=>$objType,":UID"=>$adminId);
		AdminApproveSessionModel::model()->deleteAll($c);    	
    }
}