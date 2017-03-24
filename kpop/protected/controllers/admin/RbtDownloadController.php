<?php

class RbtDownloadController extends Controller {

    public $time;

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý Rbt Download ");

        if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
            $createdTime = $_GET['songreport']['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['songreport']['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                ///$this->time = $time;
                $this->time = array('from' => $time.' 00:00:00', 'to' => $time. ' 23:59:59');
            }
        } else {
//            $startDay = date("Y") . "-" . date("m") . "-01";
//            $fromDate = date("Y-m-d", strtotime($startDay));
//            $toDate = date("Y-m-d");
//            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
    }
 
    
    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new RbtDownloadModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RbtDownloadModel']))
            $model->attributes = $_GET['RbtDownloadModel'];

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize
        ));
    }

    public function actionReport() {
        $model = new RbtDownloadModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['songreport']['date'])) {
            $model->setAttribute("download_datetime", $this->time);
        }
        else{
            $date = date("m/d/Y");
            $time = explode("/", trim($date));
            $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
             
            $this->time = array('from' => $time.' 00:00:00', 'to' => $time. ' 23:59:59');
            $model->setAttribute("download_datetime", $this->time);
        }
        
        $_channel = "";
        
        if (!empty($_GET['channel'])) {
            $_channel = $_GET['channel'];            
            $model->setAttribute("channel", $_channel);            
        }

        $channel = array('' => 'all', 'web' => 'web', 'wap' => 'wap', 'sms' => 'sms', 'api' => 'api', 'crbt' => 'crbt');


        $count_channel = RbtDownloadModel::model()->getCountChannel($this->time, $_channel);
        foreach ($count_channel as $cc) {
            $count_channel[$cc['channel']] = $cc['total'];
            $count_channel['all'] += $cc['total'];
        }

        $total_money = RbtDownloadModel::model()->getTotalMoney($this->time, $_channel);
        if (!isset($total_money))
            $total_money = 0;
        $this->render('report', array(
            'model' => $model,
            'channel' => $channel,
            'count_channel' => $count_channel,
            'total_money' => $total_money,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RbtDownloadModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RbtDownloadModel'])) {
            $model->attributes = $_POST['RbtDownloadModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['RbtDownloadModel'])) {
            $model->attributes = $_POST['RbtDownloadModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
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

        if (isset($_POST['RbtDownloadModel'])) {
            $model = new RbtDownloadModel;
            $model->attributes = $_POST['RbtDownloadModel'];
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
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        if (isset($_POST['all-item'])) {
            RbtDownloadModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            RbtDownloadModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RbtDownloadModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rbt-download-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
