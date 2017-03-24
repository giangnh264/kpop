<?php
Class UserAccess
{
    public static function checkAccess($accessName,$fake = false) {
    	if(Yii::app()->getModule('srbac')->debug) return true;
    	$sessionNameCheck = $accessName."_".Yii::app()->user->id;
    	
    	if(!isset(Yii::app()->session[$sessionNameCheck])){
    		Yii::app()->session[$sessionNameCheck] = Yii::app()->user->checkAccess($accessName);
    	}
    	return Yii::app()->session[$sessionNameCheck];
    }
}
?>
