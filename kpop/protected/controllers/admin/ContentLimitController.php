<?php

class ContentLimitController extends Controller
{
	public $listContentType = array(
			'song'=>'Bài hát',
			'video'=>'Video',
			'album'=>'Album - chỉ áp dụng cho Album',
			'album_song'=>'Album - áp dụng cho cả Bài hát',
			
	);
	
    public function init()
	{
		parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  Content Limit ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminContentLimitModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminContentLimitModel']))
			$model->attributes=$_GET['AdminContentLimitModel'];

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
		$model=new AdminContentLimitModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminContentLimitModel']))
		{
			$_state = true;
			$beginTime =  $_POST["AdminContentLimitModel"]["begin_time"];
			$beginTime = str_replace("/", "-", $beginTime);
			$endTime =  $_POST["AdminContentLimitModel"]["end_time"];
			$endTime = str_replace("/", "-", $endTime);
			$applyFor = isset($_POST["apply_for"])?$_POST["apply_for"]:array();
			$channelData = isset($_POST["channel"])?$_POST["channel"]:array();
						 
			if(empty($applyFor)){
				$model->addError("apply", "Chưa chọn đối tượng áp dụng");
				$_state = false;
			}
			if(empty($channelData)){
				$model->addError("channel", "Chưa chọn kênh áp dụng");
				$_state = false;
			}
			
			if($beginTime=="" || $endTime==""){
				$model->addError("time", "Chưa chọn thời gian");
				$_state = false;
			}
			if(strtotime($beginTime) > strtotime($endTime)){
				$model->addError("time", "Thời gian không hợp lệ");
				$_state = false;
			}
			
			if(!isset($_POST["ids"]) || $_POST["ids"]==""){
				$model->addError("ids", "Chưa nhập id nội dung");
			}
			if($_state){
				$ids = $_POST["ids"];
				$ids = explode(",", $ids);
				$apply = implode(",", $applyFor);
				$channel = implode(",", $channelData);
				$beginTime.=":00";
				$endTime.=":00";
				
				foreach($ids as $id){
					$obj = array();
					$orgType = $contentType = $_POST["AdminContentLimitModel"]["content_type"];
					 
					switch ($_POST["AdminContentLimitModel"]["content_type"]){
						case "song":
							$obj = SongModel::model()->findByPk($id);
							break;
						case "video":
							$obj = VideoModel::model()->findByPk($id);
							break;
						case "album":
						case "album_song":
							$contentType = "album";
							$obj = AlbumModel::model()->findByPk($id);
							break;
					}
					if(!empty($obj)){
						$msg_warning = $_POST["AdminContentLimitModel"]["msg_warning"];
						
						$sql = "INSERT INTO content_limit(content_id,content_name,content_type,apply,begin_time,end_time,channel,msg_warning)
								VALUES (:CONTENT_ID,:CONTENT_NAME,:CONTENT_TYPE,:APPLY,:BEGIN,:END,:CHANNEL,:MSG)
								ON DUPLICATE KEY UPDATE content_name=:CONTENT_NAME,apply=:APPLY,begin_time=:BEGIN,end_time=:END,channel=:CHANNEL,msg_warning=:MSG
								";
						$command = Yii::app()->db->createCommand($sql);
						$command->bindParam(":CONTENT_ID", $id,PDO::PARAM_INT);
						$command->bindParam(":CONTENT_NAME", $obj->name,PDO::PARAM_STR);
						$command->bindParam(":CONTENT_TYPE", $contentType,PDO::PARAM_STR);
						$command->bindParam(":APPLY", $apply,PDO::PARAM_STR);
						$command->bindParam(":BEGIN", $beginTime,PDO::PARAM_STR);
						$command->bindParam(":END", $endTime,PDO::PARAM_STR);
						$command->bindParam(":CHANNEL", $channel,PDO::PARAM_STR);
						$command->bindParam(":MSG", $msg_warning,PDO::PARAM_STR);
						$command->execute();
						
						// Luu cac bai hat trong truong hop la album
						if($orgType=="album_song"){
							$sql = "SELECT t1.*, t2.name 
									FROM album_song t1
									INNER JOIN song t2 ON t1.song_id = t2.id
									WHERE t1.album_id=:AID
									";
							$command = Yii::app()->db->createCommand($sql);
							$command->bindParam(":AID", $id,PDO::PARAM_INT);
							$songs = $command->queryAll(); 
							foreach($songs as $song){
								$sql = "INSERT INTO content_limit(content_id,content_name,content_type,apply,begin_time,end_time,channel,msg_warning)
								VALUES (:CONTENT_ID,:CONTENT_NAME,'song',:APPLY,:BEGIN,:END,:CHANNEL,:MSG)
								ON DUPLICATE KEY UPDATE apply=:APPLY,begin_time=:BEGIN,end_time=:END,channel=:CHANNEL,msg_warning=:MSG
								";
								$command = Yii::app()->db->createCommand($sql);
								$command->bindParam(":CONTENT_ID", $song["song_id"],PDO::PARAM_INT);
								$command->bindParam(":CONTENT_NAME", $song["name"],PDO::PARAM_STR);
								$command->bindParam(":APPLY", $apply,PDO::PARAM_STR);
								$command->bindParam(":BEGIN", $beginTime,PDO::PARAM_STR);
								$command->bindParam(":END", $endTime,PDO::PARAM_STR);
								$command->bindParam(":CHANNEL", $channel,PDO::PARAM_STR);
								$command->bindParam(":MSG", $msg_warning,PDO::PARAM_STR);
								$command->execute();
							}
						}
					}
				}
				$this->redirect(array('index'));
			}	
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

		if(isset($_POST['AdminContentLimitModel']))
		{
			$_state = true;
			$beginTime =  $_POST["AdminContentLimitModel"]["begin_time"];

			$beginTime = str_replace("/", "-", $beginTime);
			$endTime =  $_POST["AdminContentLimitModel"]["end_time"];
			$endTime = str_replace("/", "-", $endTime);
			$applyFor = isset($_POST["apply_for"])?$_POST["apply_for"]:array();
			$channelData = isset($_POST["channel"])?$_POST["channel"]:array();
				
			if(empty($applyFor)){
				$model->addError("apply", "Chưa chọn đối tượng áp dụng");
				$_state = false;
			}
			if(empty($channelData)){
				$model->addError("channel", "Chưa chọn kênh áp dụng");
				$_state = false;
			}
				
			if($beginTime=="" || $endTime==""){
				$model->addError("time", "Chưa chọn thời gian");
				$_state = false;
			}
			if(strtotime($beginTime) > strtotime($endTime)){
				$model->addError("time", "Thời gian không hợp lệ");
				$_state = false;
			}
				
			if(!isset($_POST["ids"]) || $_POST["ids"]==""){
				$model->addError("ids", "Chưa nhập id nội dung");
			}
			if($_state){
				
				$apply = implode(",", $applyFor);
				$channel = implode(",", $channelData);
				$beginTime.=":00";
				$endTime.=":00";
				
				$model->apply = $apply;
				$model->channel = $channel;
				$model->begin_time = $beginTime;
				$model->end_time = $endTime;
				$model->msg_warning= $_POST["AdminContentLimitModel"]["msg_warning"];
				if($model->save()){
					$this->redirect(array('view','id'=>$model->id));
				}					

			}
		}

		$this->render('update',array(
			'model'=>$model,
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
        	AdminContentLimitModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminContentLimitModel::model()->deleteAll($c);
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
		$model=AdminContentLimitModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-content-limit-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
