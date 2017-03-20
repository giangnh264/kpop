<?php

class ApisourceController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Api Source") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminApiSourceModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminApiSourceModel']))
			$model->attributes=$_GET['AdminApiSourceModel'];

		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$reload = Yii::app()->request->getParam('reload',0);
		$model = $this->loadModel($id);
		if($reload){
			$content = $this->_getContentCurl($model->api_url);
			$object = json_decode($content);
			
			$c = new CDbCriteria();
			$c->condition = "api_id={$id}";
			AdminApiObjectModel::model()->deleteAll($c);
			foreach($object as $item){
				$objContent = new AdminApiObjectModel();
				$objContent->api_id = $id;
				$objContent->object_id = $item->CONTENTID;
				$objContent->title = $item->TITLE;
				$objContent->description = $item->CONTENT;
				$objContent->thumb_url = $item->IMG2;
				$objContent->link = $item->DETAIL_URL;
				$objContent->total_download = $item->DOWNLOADTIMES;
				$objContent->total_play = 0;
				$ret = $objContent->save();
			}
			$this->redirect(array('view','id'=>$id));	
		}
		
		$objectList = new AdminApiObjectModel('search');
		$objectList->unsetAttributes();  // clear any default values
		$objectList->setAttribute('api_id',$id);
		$this->render('view',array(
			'model'=>$model,
			'objectList'=>$objectList,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminApiSourceModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminApiSourceModel']))
		{
			$model->attributes=$_POST['AdminApiSourceModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminApiSourceModel']))
		{
			$model->attributes=$_POST['AdminApiSourceModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

                /**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id)
	{
		$data = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminApiSourceModel']))
		{
                        $model=new AdminApiSourceModel;
			$model->attributes=$_POST['AdminApiSourceModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('copy',array(
			'model'=>$data,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
    * bulk Action.
    * @param string the action
    */
    public function actionBulk() {
    	$act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) &&  $act != "") {
        	$this->forward($this->getId()."/" . $act);
        }else {
        	$this->redirect(array('index'));
        }
	}

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	AdminApiSourceModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminApiSourceModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminApiSourceModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-api-source-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	protected static function _getContentCurl($url) {
		// timeout in seconds
		$timeOut = 5;
		$result = false;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeOut);
		$rawdata=curl_exec($ch);
		if(curl_errno( $ch ))
		{
			throw new CHttpException(404,'Không lấy được dữ liệu mới từ api url');
		}
		curl_close ($ch);

		return $rawdata;
	}
}
