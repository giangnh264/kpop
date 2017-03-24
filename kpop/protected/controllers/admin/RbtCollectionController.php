<?php

class RbtCollectionController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý bộ sưu tập nhạc chờ");
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new RbtCollectionModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RbtCollectionModel']))
            $model->attributes = $_GET['RbtCollectionModel'];

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
        $rbtItemList = new AdminRbtCollectionItemModel;
        $rbtItemList->unsetAttributes();
        if (isset($_GET['AdminRbtCollectionItemModel'])) {
            $rbtItemList->attributes = $_GET['AdminRbtCollectionItemModel'];
        }
        $rbtItemList->setAttribute('collect_id', $id);


        /// cho ham Search
        $rbt = new AdminRbtModel;
        $rbt->unsetAttributes();
        if (isset($_GET['AdminRbtModel'])) {
            $rbt->attributes = $_GET['AdminRbtModel'];
        }

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'rbtList' => $rbtItemList,
            'rbt' => $rbt,
            'group_id' => $id
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RbtCollectionModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RbtCollectionModel'])) {
            $model->attributes = $_POST['RbtCollectionModel'];
            $model->created_by = Yii::app()->user->id;
            $model->created_time = date("Y-m-d H:i:s");

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

        if (isset($_POST['RbtCollectionModel'])) {
            $model->attributes = $_POST['RbtCollectionModel'];
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

        if (isset($_POST['RbtCollectionModel'])) {
            $model = new RbtCollectionModel;
            $model->attributes = $_POST['RbtCollectionModel'];
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
            RbtCollectionModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            RbtCollectionModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RbtCollectionModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rbt-collection-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');

        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->order = "sorder ASC, id DESC";
        $songF = AdminRbtCollectionModel::model()->findAll($c);

        $i = 1;
        foreach ($songF as $songF) {
            if (!isset($data[$songF->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$songF->id];
            }
            $songObj = AdminRbtCollectionModel::model()->findByPk($songF->id);
            $songObj->sorder = $order;
            $songObj->save();
            $i++;
        }
    }

}
