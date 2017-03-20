<?php

class RingbacktoneController extends Controller
{

    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý nhạc chờ") ;

           	$this->slidebar=array(
					array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'),"active"=>"active"),
					array('label'=>Yii::t('admin', 'Thể loại'), 'url'=>array('/ringbacktoneCategory')),
              );
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminRbtModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminRbtModel']))
			$model->attributes=$_GET['AdminRbtModel'];

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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminRbtModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminRbtModel']))
		{
			$model->attributes=$_POST['AdminRbtModel'];
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

		if(isset($_POST['AdminRbtModel']))
		{
			$model->attributes=$_POST['AdminRbtModel'];
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

		if(isset($_POST['AdminRbtModel']))
		{
                        $model=new AdminRbtModel;
			$model->attributes=$_POST['AdminRbtModel'];
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
        	AdminRbtModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminRbtModel::model()->deleteAll($c);
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
		$model=AdminRbtModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-rbt-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function actionList() {
        $flag = true;
        $collection = Yii::app()->request->getParam('collection');
        $group_id = Yii::app()->request->getParam('group_id');
        $actiontype = Yii::app()->request->getParam('actiontype');

        $object = Yii::app()->request->getParam('object',"");
        $collect_id = Yii::app()->request->getParam('collect_id',"");

        if (!isset($collection))
            $collection = "";
        if (!isset($group_id))
            $group_id = "";
        if (!isset($actiontype))
            $actiontype = "";

        if (Yii::app()->getRequest()->ispostRequest) {
            $collection = Yii::app()->request->getParam('collection');
            $actiontype = Yii::app()->request->getParam('actiontype');
            if($object == "collection"){
				$flag = false;
				$rbtList = Yii::app()->request->getParam('cid');
				AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $rbtList,'rbt');
			} else if ($collection == "yes") {
                $flag = false;
                $rbtList = Yii::app()->request->getParam('cid');
                $group_id = Yii::app()->request->getParam('group_id');
                AdminRbtCollectionItemModel::model()->addList($group_id, $rbtList);
            } else if ($actiontype == "addNew") {
                $flag = false;
                $rbtList = Yii::app()->request->getParam('cid');
                AdminRbtNewModel::model()->addList($this->userId, $rbtList);
            }
        }

        if ($flag) {
            $categoryList = AdminGenreModel::model()->gettreelist(2);
            $cpList = AdminCpModel::model()->findAll();
            $pageSize = Yii::app()->request->getParam('pageSize', 20);
            Yii::app()->user->setState('pageSize', $pageSize);
            $model = new AdminRbtModel('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['AdminRbtModel'])) {
                $model->attributes = $_GET['AdminRbtModel'];
            }
            $model->setAttribute("deleted", 0);
            //$model->setAttribute("status", AdminRbtModel::ACTIVE);
            //$model->setAttribute("sync_status", 1);

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('list', array(
                'model' => $model,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                'collection' => $collection,
                'group_id' => $group_id,
                'actiontype' => $actiontype,
                'object' => $object,
                'collect_id' => $collect_id
                    ), false, true);
        }
    }
}
