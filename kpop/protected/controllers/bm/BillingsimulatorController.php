<?php
class BillingsimulatorController extends CController
{
	public function actionIndex()
	{
		if(Yii::app()->request->isPostRequest){
			$post = file_get_contents('php://input');
			
			$curl = curl_init("http://10.50.9.60:18088");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
			$content  = curl_exec($curl);
			echo $content;
		} 
		Yii::app()->end();
	}
}
