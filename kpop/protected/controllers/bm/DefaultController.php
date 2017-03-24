<?php
class DefaultController extends CController
{
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	echo "<pre>";print_r($error);exit(); 
	    }
	}
}