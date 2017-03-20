<?php

class CopyrightController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý phụ lục ");
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new CopyrightModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CopyrightModel']))
            $model->attributes = $_GET['CopyrightModel'];

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $songList = new AdminSongCopyrightModel("search");
        $songList->unsetAttributes();
        $songList->setAttributes(array('copryright_id' => $id));
        $songList->pageSize = 10;

        $videoList = new AdminVideoCopyrightModel("search");
        $videoList->unsetAttributes();
        $videoList->setAttributes(array('copryright_id' => $id));
        $videoList->pageSize = 10;

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'songList'=>$songList,
            'videoList'=>$videoList,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CopyrightModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CopyrightModel'])) {
            $model->attributes = $_POST['CopyrightModel'];

            if (isset($_POST['active_time']) && $_POST['active_time'] != "") {
                $active_time = $_POST['active_time'];
                if (strrpos($active_time, "-")) {
                    $createdTime = explode("-", $active_time);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 23:59:59";
                }
                $model->setAttribute("due_date", $toDate);
                $model->setAttribute("start_date", $fromDate);
            }
            $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
            $cpId = $adminUser->cp_id;
            $model->setAttribute('added_time', date('Y-m-d H:i:s'));
            $model->setAttribute('updated_time', date('Y-m-d H:i:s'));
            $model->setAttribute('added_by', $cpId);
            $model->setAttribute('updated_by', $cpId);

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $ccpList = AdminCcpModel::model()->findAll();
        $this->render('create', array(
            'model' => $model,
            'ccpList'=>$ccpList,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CopyrightModel'])) {
            $model->attributes = $_POST['CopyrightModel'];

            if (isset($_POST['active_time']) && $_POST['active_time'] != "") {
                $active_time = $_POST['active_time'];
                if (strrpos($active_time, "-")) {
                    $createdTime = explode("-", $active_time);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['active_time']));
                    $toDate = date("Y-m-d", strtotime($_GET['active_time']));
                }
                $model->setAttribute("due_date", $toDate);
                $model->setAttribute("start_date", $fromDate);
            }
            $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
            $cpId = $adminUser->cp_id;
            $model->setAttribute('updated_time', date('Y-m-d H:i:s'));
            $model->setAttribute('updated_by', $cpId);

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $ccpList = AdminCcpModel::model()->findAll();
        $this->render('update', array(
            'model' => $model,
            'ccpList'=>$ccpList,
        ));
    }

    /**
     * Copy record
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be copy
     */
    public function actionCopy($id) {
        $data = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CopyrightModel'])) {
            $model = new CopyrightModel;
            $model->attributes = $_POST['CopyrightModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('copy', array(
            'model' => $data,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            if($this->loadModel($id)->delete()){
            	$this->removeCoppyright($id);
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	private function removeCoppyright($cprId)
	{
		$sql = "DELETE FROM song_copyright WHERE copryright_id=:cprId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':cprId', $cprId, PDO::PARAM_INT);
		$songCPDelte = $command->execute();
		
		$sql = "DELETE FROM video_copyright WHERE copryright_id=:cprId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':cprId', $cprId, PDO::PARAM_INT);
		$videoCPDelte = $command->execute();
		return ($songCPDelte && $videoCPDelte);
	}
    /**
     * bulk Action.
     * @param string the action
     */
    public function actionBulk() {
        $act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) && $act != "") {
            $this->forward($this->getId() . "/" . $act);
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
     * Delete all record Action.
     * @param string the action
     */
    public function actionDeleteAll() {
    	echo "Your Request is Invalid!.";
    	exit;
        if (isset($_POST['all-item'])) {
            CopyrightModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            CopyrightModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    public function actionRemoveAll()
    {
        if(Yii::app()->request->isPostRequest){
            $cprId = Yii::app()->request->getParam('cpr_id');
            $cprId = (int) $cprId;
            $cond = "copryright_id='{$cprId}'";
            SongCopyrightModel::model()->deleteAll($cond);
            $this->redirect(array('view', 'id' => $cprId));
        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionRemoveSong()
    {
        if(Yii::app()->request->isPostRequest){
            if(!empty($_FILES["file_song"]) && $_FILES['file_song']['type']== 'text/plain'){
                $cprId = Yii::app()->request->getParam('cpr_id');
                $fileUpload = $_FILES['file_song'];
                $tmpPath = _APP_PATH_.DS."/data/tmp".DS.time().".txt";

                if($fileUpload["error"]==0){
                    $ret = move_uploaded_file($_FILES['file_song']['tmp_name'],$tmpPath);
                    if($ret){
                        $songIds = file_get_contents($tmpPath);
                        $songIds = explode("\n", trim($songIds));
                        $songIds = array_chunk($songIds, 100);
                        foreach($songIds as $ss){
                            if(count($ss)>0){
                                $ids = implode(",", $ss);
                                //$cond = "copryright_id='{$cprId}' AND song_id IN({$ids})";
                                $cond = "song_id IN({$ids})";
                                SongCopyrightModel::model()->deleteAll($cond);
                            }
                        }
                    }else{
                        Yii::app()->user->setFlash('error',"Không lưu được upload file ({$tmpPath})");
                    }
                }else{
                    Yii::app()->user->setFlash('error',"Lỗi khi upload file ({$fileUpload["error"]})");
                }
            }else{
                Yii::app()->user->setFlash('error',"File upload phải là định dạng txt");
            }
            $this->redirect(array('view', 'id' => $cprId));
        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }


    public function actionRemoveAllVideo()
    {
        if(Yii::app()->request->isPostRequest){
            $cprId = Yii::app()->request->getParam('cpr_id');
            $cprId = (int) $cprId;
            $cond = "copryright_id='{$cprId}'";
            VideoCopyrightModel::model()->deleteAll($cond);
            $this->redirect(array('view', 'id' => $cprId));
        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionRemoveVideo()
    {
        if(Yii::app()->request->isPostRequest){
            if(!empty($_FILES["file_song"]) && $_FILES['file_song']['type']== 'text/plain'){
                $cprId = Yii::app()->request->getParam('cpr_id');
                $fileUpload = $_FILES['file_song'];
                $tmpPath = _APP_PATH_.DS."/data/tmp".DS.time().".txt";

                if($fileUpload["error"]==0){
                    $ret = move_uploaded_file($_FILES['file_song']['tmp_name'],$tmpPath);
                    if($ret){
                        $songIds = file_get_contents($tmpPath);
                        $songIds = explode("\n", trim($songIds));
                        $songIds = array_chunk($songIds, 100);
                        foreach($songIds as $ss){
                            if(count($ss)>0){
                                $ids = implode(",", $ss);
                                $cond = "video_id IN({$ids})";
                                VideoCopyrightModel::model()->deleteAll($cond);
                            }
                        }
                    }else{
                        Yii::app()->user->setFlash('error',"Không lưu được upload file ({$tmpPath})");
                    }
                }else{
                    Yii::app()->user->setFlash('error',"Lỗi khi upload file ({$fileUpload["error"]})");
                }
            }else{
                Yii::app()->user->setFlash('error',"File upload phải là định dạng txt");
            }
            $this->redirect(array('view', 'id' => $cprId));
        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CopyrightModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'copyright-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
