<?php

class PlaylistFeatureController extends Controller
{

	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Quản lý  Feature Playlist") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		/*
		$this->slidebar=array(
							array('label'=>yii::t('admin', 'Danh sách playlist'), 'url'=>array('/playlist/index')),
							array('label'=>yii::t('admin', 'Playlist chọn lọc'), 'url'=>array('/playlistFeature/index'),"active"=>"active"),
						);
		*/
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminFeaturePlaylistModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminFeaturePlaylistModel']))
		$model->attributes=$_GET['AdminFeaturePlaylistModel'];

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
		$model=new AdminFeaturePlaylistModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminFeaturePlaylistModel']))
		{
			$model->attributes=$_POST['AdminFeaturePlaylistModel'];
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

		if(isset($_POST['AdminFeaturePlaylistModel']))
		{
			$model->attributes=$_POST['AdminFeaturePlaylistModel'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAddItems()
	{
		$flag=true;
        
        $object = Yii::app()->request->getParam('object',"");
        
        $collect_id = Yii::app()->request->getParam('collect_id',"");
        
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
            if($object == "collection"){				
				$playlistList = Yii::app()->request->getParam('cid');
				AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $playlistList, 'playlist');
			}
            else{
                $cids = Yii::app()->request->getParam('cid');
                $featureP = AdminFeaturePlaylistModel::model()->findAll();
                $featureP = CHtml::listData($featureP,'id','playlist_id');
                for($i=0;$i<count($cids);$i++){
                    if(!in_array($cids[$i],$featureP) ){
                        $model=new AdminFeaturePlaylistModel();
                        $model->playlist_id = $cids[$i];
                        $model->created_by = $this->userId;
                        $model->created_time = date("Y-m-d H:i:s"); 
                        if(!$model->save()){
                            $error = $model->geterrors();
                            echo "<pre>";print_r($error);exit(); 
                        }
                    }
                }
           }
		}
		if($flag){
			Yii::app()->user->setState('pageSize',15);
			$playlist = new AdminPlaylistModel('search');
			$playlist->unsetAttributes();
			
			if(isset($_GET['AdminPlaylistModel']))
				$playlist->attributes=$_GET['AdminPlaylistModel'];
			

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_addItems',array(
	                            'playlist'=>$playlist,
                                'object' => $object,
                                'collect_id' => $collect_id
			),false,true);
		}		
	}
	
	/**
	 * bulk Action.
	 * @param string the action
	 */
	public function actionBulk() {
		$act = Yii::app()->request->getParam('bulk_action', null);
		if (isset($act) &&  $act != "") {
			$this->forward("playlistFeature/$act");
		}else {
			$this->redirect(array('index'));
		}
	}	
	
    public function actionReorderItems()
    {
        $data = Yii::app()->request->getParam('sorder',array());
        foreach($data as $k=>$v){
        	if(isset($v) && $v !=""){
        		$playlistF = AdminFeaturePlaylistModel::model()->findByPk($k);
	            $playlistF->sorder = $v;
	            $playlistF->save();
        	}
        }
    }
    
	public function actionDeleteItems()
	{
		if(isset($_POST['all-item'])){
			AdminFeaturePlaylistModel::model()->deleteAll();
		}else{
			$items = yii::app()->request->getparam('cid');
			$items = implode(",", $items);
			$condition = "id IN ($items)";
			AdminFeaturePlaylistModel::model()->deleteAll($condition);
		}
		
		
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect("/playlistFeature/index");
		} 		
	}
		
	public function actionPublishItems()
	{
		$items = yii::app()->request->getparam('cid');
		$items = implode(",", $items);
		$attributes['status'] = 0;
		$condition = "id IN ($items)";
		AdminFeaturePlaylistModel::model()->updateAll($attributes,$condition);
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect("/playlistFeature/index");
		} 
	}
	
	public function actionUnpublishItems()
	{
		$items = yii::app()->request->getparam('cid');
		$items = implode(",", $items);
		$attributes['status'] = 1;
		$condition = "id IN ($items)";
		AdminFeaturePlaylistModel::model()->updateAll($attributes,$condition);
		
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect("/playlistFeature/index");
		} 
	}
	
	/**
	 * Delete all record Action.
	 * @param string the action
	 */
	public function actionDeleteAll() {
		if(isset($_POST['all-item'])){
			AdminFeaturePlaylistModel::model()->deleteAll();
		}else{
			$item = $_POST['cid'];
			$c =  new CDbCriteria;
			$c->condition = ('id in ('.implode($item, ",").')');
			$c->params = null;
			AdminFeaturePlaylistModel::model()->deleteAll($c);
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
		$model=AdminFeaturePlaylistModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-feature-playlist-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
