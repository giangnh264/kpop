<?php
class IndexController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
		$this->layout = 'application.views.web.layouts.main';
		$error = Yii::app()->errorHandler->error;
		$this->render('error', array('error'=>$error) );
	}

	public function actionLoadJs()
	{
		$path = Yii::getPathOfAlias('application.messages').DS.Yii::app()->language.DS."js.php";
		$data = array();
		if(file_exists($path)){
			$data = require_once $path;
		}
		$user_sub = $this->user_sub;
		$this->renderPartial("loadJs",compact("data","user_sub"));
	}

	public function  actionLimitContent()
	{
		$contentId = Yii::app()->request->getParam('content_id');
		$contentType = Yii::app()->request->getParam('content_type');
		$userType = Yii::app()->request->getParam('user_type');
		$per = ContentLimitModel::getPermision($contentId, $contentType, $userType,"WEB");
		$this->render("limitContent",compact("per"));
	}
}
