<?php

class RingtoneCategoryController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', 'Thể loại nhạc chuông');
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Tất cả'), 'url'=>array('/ringtone/index')),
          array('label'=>Yii::t('admin', 'Chưa convert'), 'url'=>array('/ringtone/index',"AdminRingtoneModel[status]"=>AdminRingtoneModel::NOT_CONVERT)),
          array('label'=>Yii::t('admin', 'Convert lỗi'), 'url'=>array('/ringtone/index',"AdminRingtoneModel[status]"=>AdminRingtoneModel::CONVERT_FAIL)),
          array('label'=>Yii::t('admin', 'Chờ duyệt'), 'url'=>array('/ringtone/index',"AdminRingtoneModel[status]"=>AdminRingtoneModel::WAIT_APPROVED)),
          array('label'=>Yii::t('admin', 'Đã duyệt'), 'url'=>array('/ringtone/index',"AdminRingtoneModel[status]"=>AdminRingtoneModel::ACTIVE)),
          array('label'=>Yii::t('admin', 'Đã xóa'), 'url'=>array('/ringtone/index',"AdminRingtoneModel[status]"=>AdminRingtoneModel::DELETED)),
          array('label'=>Yii::t('admin', 'Thể loại nhạc chuông'), 'url'=>array('/ringtoneCategory'),"active"=>"active"),
          );
         */
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminRingtoneCategoryModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminRingtoneCategoryModel']))
            $model->attributes = $_GET['AdminRingtoneCategoryModel'];

        $treeData = AdminRingtoneCategoryModel::model()->gettreelist(1);
        $this->render('index', array(
            'model' => $model,
            'treeData' => $treeData
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
        $model = new AdminRingtoneCategoryModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AdminRingtoneCategoryModel'])) {
            $model->attributes = $_POST['AdminRingtoneCategoryModel'];
            $model->setAttribute('created_by', $this->userId);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $this->render('create', array(
            'model' => $model,
            'categoryList' => $categoryList,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['AdminRingtoneCategoryModel'])) {
            $model->attributes = $_POST['AdminRingtoneCategoryModel'];
            if ($model->id == $_POST['AdminRingtoneCategoryModel']['parent_id']) {
                $model->setAttribute('parent_id', '0');
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $this->render('update', array(
            'model' => $model,
            'categoryList' => $categoryList,
        ));
    }

    /**
     * Copy record
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be copy
     */
    public function actionCopy($id) {
        $data = $this->loadModel($id);

        if (isset($_POST['AdminRingtoneCategoryModel'])) {
            $model = new AdminRingtoneCategoryModel;
            $model->attributes = $_POST['AdminRingtoneCategoryModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $this->render('copy', array(
            'model' => $data,
            'categoryList' => $categoryList,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $child = AdminRingtoneCategoryModel::model()->findAll("parent_id=:PID", array(":PID" => $id));
            $ringtone = AdminRingtoneCategoryModel::model()->findAll("category_id=:GID", array(":GID" => $id));
            if (empty($child) && empty($song)) {
                $this->loadModel($id)->delete();
            }


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
            AdminRingtoneCategoryModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            AdminRingtoneCategoryModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminRingtoneCategoryModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-ringtone-category-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
