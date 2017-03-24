<?php

Yii::import("ext.xupload.models.XUploadForm");

class RingtoneController extends Controller {

    public $type = AdminRingtoneModel::ALL;

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  Ringtone");
        $type = Yii::app()->request->getParam('AdminRingtoneModel');
        $this->type = (isset($type['status']) && $type['status'] != "") ? $type['status'] : AdminRingtoneModel::ALL;
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ . DS . "data",
                'alowType' => 'audio/mpeg,audio/mp3'
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminRingtoneModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminRingtoneModel'])) {
            $model->attributes = $_GET['AdminRingtoneModel'];
            if (isset($_GET['AdminRingtoneModel']['created_time']) && $_GET['AdminRingtoneModel']['created_time'] != "") {
                // Re-setAttribute create datetime
                $createdTime = $_GET['AdminRingtoneModel']['created_time'];
                if (strrpos($createdTime, "-")) {
                    $createdTime = explode("-", $createdTime);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['AdminRingtoneModel']['created_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['AdminRingtoneModel']['created_time'])) . " 23:59:59";
                }
                $model->setAttribute("created_time", array(0 => $fromDate, 1 => $toDate));
            }
        }

        // Default none display rt delete
        ///if($this->type != -1)
            $model->setAttribute("status", $this->type);
        if ($this->cpId != 0) {
            $model->setAttribute("cp_id", $this->cpId);
        }

        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $cpList = AdminCpModel::model()->findAll();
        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
            'categoryList' => $categoryList,
            'cpList' => $cpList
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        /*
          $this->slidebar=array(
          array('label'=>yii::t('admin', 'Thông tin cơ bản'), 'url'=>'#',"active"=>"active"),
          );
         */

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new AdminRingtoneModel;
        if (isset($_POST['AdminRingtoneModel'])) {
            $cpId = $this->cpId;
            if ($cpId == 0) {
                $cpId = $_POST['AdminRingtoneModel']['cp_id'];
            }
            $rtCode = AdminAdminUserModel::model()->getMaxContentCode($cpId, 'ringtone');
            if (!$rtCode) {
                $_GET['msg'] = Yii::t('admin', 'Tài khoản đã hết quyền upload nhạc chuông cho CP: ' . $cpId);
                $this->forward("admin/error", true);
            }

            $artistList = $_POST['AdminAlbumModel_artist_id_list'];
            $model->attributes = $_POST['AdminRingtoneModel'];
            $model->setAttributes(
                    array(
                        'code' => $rtCode,
                        'created_by' => $this->userId,
                        'cp_id' => $cpId,
                        'price' => Yii::app()->params['price']['rtDownload'],
                        'created_time' => date("Y-m-d H:i:s"),
                        'updated_time' => date("Y-m-d H:i:s"),
                        'artist_id' => $artistList[0],
                        'artist_name' => AdminArtistModel::model()->findByPk($artistList[0])->name,
                    )
            );

            $file = Yii::app()->params['storage']['staticDir'] . DS . 'data' . DS . 'tmp' . DS . $_POST['source_path'];
            //echo $file;exit;
            if (file_exists($file)) {
                if ($model->save()) {
                    $this->moveFile($model, $file);
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                $model->addError("file", Yii::t('admin', 'Chưa có file upload'));
            }
        }
        $uploadModel = new XUploadForm();
        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $cpList = AdminCpModel::model()->findAll();
        $this->render('create', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'categoryList' => $categoryList,
            'cpList' => $cpList
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $uploadModel = new XUploadForm();

        $model = $this->loadModel($id);

        if (isset($_POST['AdminRingtoneModel'])) {

            $data = array('updated_time' => date("Y-m-d H:i:s"),);
            //check exits file
            $file = Yii::app()->params['storage']['staticDir'] . DS . 'data' . DS . 'tmp' . DS . $_POST['source_path'];
            if (file_exists($file)) {
                $this->moveFile($model, $file);
                $data['approved_by'] = 0;
                $_POST['AdminRingtoneModel']['status'] = AdminRingtoneModel::NOT_CONVERT;
            }

            $rtStatus = $_POST['AdminRingtoneModel']['status'];
            unset($_POST['AdminRingtoneModel']['status']);

            $model->attributes = $_POST['AdminRingtoneModel'];

            $artistList = $_POST['AdminAlbumModel_artist_id_list'];
            $model->setAttributes(
            		array(
            				'artist_id' => $artistList[0],
            				'artist_name' => AdminArtistModel::model()->findByPk($artistList[0])->name,
            		));

            if ($model->save()) {
                //UPDATE SONG STATUS
                $rtList[] = $id;
                if (isset($rtStatus)) {
                    switch ($rtStatus) {
                        case AdminRingtoneModel::NOT_CONVERT:
                            AdminRingtoneModel::model()->setReconvert($rtList);
                            break;
                        case AdminRingtoneModel::WAIT_APPROVED:
                            AdminRingtoneModel::model()->setWaitApproved($rtList, $this->userId);
                            break;
                    }
                }
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                exit();
            }
        }

        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $cpList = AdminCpModel::model()->findAll();
        $this->render('update', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'categoryList' => $categoryList,
            'cpList' => $cpList
        ));
    }

    /**
     * Copy record
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be copy
     */
    public function actionCopy($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AdminRingtoneModel'])) {
            $model = new AdminRingtoneModel;
            $model->attributes = $_POST['AdminRingtoneModel'];

            $file = Yii::app()->params['storage']['staticDir'] . DS . 'data' . DS . 'tmp' . DS . $_POST['source_path'];
            if (file_exists($file)) {
                if ($model->save()) {
                    $this->moveFile($model, $file);
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                $model->addError("file", Yii::t('admin', 'Chưa có file upload'));
            }
        }

        $uploadModel = new XUploadForm();
        $categoryList = AdminRingtoneCategoryModel::model()->gettreelist(2);
        $cpList = AdminCpModel::model()->findAll();
        $this->render('copy', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'categoryList' => $categoryList,
            'cpList' => $cpList
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
            //$this->loadModel($id)->delete();

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
            $this->forward("ringtone/" . $act);
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
            //AdminRingtoneModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            //AdminRingtoneModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    public function actionHot() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminRingtoneModel::model()->updateAll(array('featured' => 1));
        } else {
            AdminRingtoneModel::model()->updateAll(array('featured' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnhot() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminRingtoneModel::model()->updateAll(array('featured' => 0));
        } else {
            AdminRingtoneModel::model()->updateAll(array('featured' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionConfirmDel() {
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $isPopup = Yii::app()->request->getParam('popup', null);
        $massList = Yii::app()->request->getParam('cid', 0);
        $type = Yii::app()->request->getParam('type', AdminRingtoneModel::ALL);
        $flag = true;

        if (Yii::app()->getRequest()->ispostRequest && $isPopup == 1) {
            $flag = false;
            $contentId = Yii::app()->request->getParam('conten_id');
            $contentAll = Yii::app()->request->getParam('is_all', 0);

            if (intval($contentAll) == 0) {
                $rtMass = explode(",", $contentId);
            } else {
                $c = new CDbCriteria();
                if ($type != AdminRingtoneModel::ALL) {
                    $c->condition = "status = :STATUS";
                    $c->params = array(":STATUS" => $type);
                }
                $rtMass = AdminRingtoneModel::model()->findAll($c);
                $rtMass = CHtml::listData($rtMass, "id", "id");
            }

            if (!empty($rtMass)) {
                $reason = Yii::app()->request->getParam('reason');
                AdminRingtoneModel::model()->setdelete($this->userId, $reason, $rtMass);
            } else {
                throw new CDbException(Yii::t('admin', 'Không có bản ghi nào được chọn'));
            }
        }

        if ($flag) {
            $massList = implode(",", $massList);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('confirmDel', array(
                'massList' => $massList,
                'isAll' => $isAll,
                'type' => $type,
                    ), false, true);
        }
    }

    public function actionApproved($id) {
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Thông tin cơ bản'), 'url'=>"#", "active"=>"active"),
          );
         */
        $return = Yii::app()->request->getParam('return', 0);
        if ($return) {
            Yii::app()->session['approvedList'] = null;
            AdminApproveSessionModel::model()->removeSession("rt", $this->userId);
            $url = $this->createUrl('ringtone/index', array('AdminRingtoneModel[status]' => 2));
            $this->redirect($url);
        }

        if (Yii::app()->getRequest()->ispostRequest) {
            if (isset($_POST['approved'])) {
                //AdminRingtoneModel::model()->updateStatus($id,$this->userId,AdminRingtoneModel::ACTIVE);
                $listRt[] = $id;
                AdminRingtoneModel::model()->setApproved($listRt, $this->userId);
            }
            if (isset($_POST['reject'])) {
                #AdminRingtoneModel::model()->updateStatus($id,$this->userId,AdminRingtoneModel::DELETED);
                #AdminRingtoneModel::model()->setdelete($this->userId,Yii::t('admin','Từ chối nhạc chuông'),$rtList);
                $rtList[] = $id;
                $reason = Yii::app()->request->getParam('reason', 'Từ chối bài hát');
                AdminRingtoneModel::model()->setdelete($this->userId, $reason, $rtList);
            }


            $data = Yii::app()->session->get('approvedList');
            $data[$id] = $id;
            Yii::app()->session->add('approvedList', $data);
            AdminApproveSessionModel::model()->removeSession("rt", $this->userId);

            // Next Ringtone
            $ringtone = AdminRingtoneModel::model()->getListByStatus(AdminRingtoneModel::WAIT_APPROVED, $this->cpId);
            if (empty($ringtone)) {
                $this->redirect(array('index', 'AdminRingtoneModel[status]' => AdminRingtoneModel::ACTIVE));
            }


            foreach ($ringtone as $ringtone) {
                $sessionCheckout = AdminApproveSessionModel::model()->contentCheckout("rt", $ringtone['id']);
                if (empty($sessionCheckout) && !in_array($ringtone['id'], Yii::app()->session['approvedList'])) {
                    $rtId = $ringtone['id'];
                    break;
                }
            }

            $url = $this->createUrl("ringtone/approved", array("id" => $rtId));
            $this->redirect($url);
        }

        $checkout = AdminApproveSessionModel::model()->contentCheckout("rt", $id);
        if (!empty($checkout)) {
            $userSession = AdminAdminUserModel::model()->findByPk($checkout['admin_id']);
        } else {
            $userSession = null;
            AdminApproveSessionModel::model()->addSession("rt", $id, $this->userId);
        }
        $ringtone = AdminRingtoneModel::model()->findByPk($id);
        $this->render("approved", array(
            'ringtone' => $ringtone,
            'checkout' => $checkout,
            'userSession' => $userSession,
        ));
    }

    public function actionApprovedAll() {
        if (Yii::app()->getRequest()->ispostRequest) {
            $isAll = isset($_POST['all-item']) ? $_POST['all-item'] : null;
            $type = Yii::app()->request->getParam('type', AdminRingtoneModel::ALL);
            if ($isAll) {
                $rtMass = AdminRingtoneModel::model()->getListByStatus($type, $this->cpId);
                $rtMass = CHtml::listData($rtMass, "id", "id");
            } else {
                $rtMass = $_POST['cid'];
            }

            AdminRingtoneModel::model()->setApproved($rtMass, $this->userId);
            $this->redirect(array('index', 'AdminRingtoneModel[status]' => AdminRingtoneModel::WAIT_APPROVED));
        }
    }

    public function actionRestore() {
        $cid = Yii::app()->request->getParam('cid', array());
        AdminRingtoneModel::model()->restore($cid, $this->userId);
        /*
          $conditionDelete = "ringtone_id in (".implode(",", $cid).")";
          $conditionRingtone = "id in (".implode(",", $cid).")";
          AdminRingtoneDeletedModel::model()->deleteAll($conditionDelete);
          $attr = array(
          'status'=>AdminRingtoneModel::NOT_CONVERT,
          'updated_by'=>$this->userId,
          'approved_by'=>0,
          'updated_time'=>date("Y-m-d H:i:s"),
          );
          AdminRingtoneModel::model()->updateAll($attr,$conditionRingtone);
         */
        $this->redirect(Yii::app()->createUrl("ringtone/index", array("AdminRingtoneModel[status]" => AdminRingtoneModel::DELETED)));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminRingtoneModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-ringtone-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function moveFile($model, $filePath) {
        $saveFilePath = $model->getRingtoneOriginPath($model->id);
        $saveDbPath = $model->getRingtoneOriginPath($model->id, false);
        $fileSystem = new Filesystem();
        $fileSystem->copy($filePath, $saveFilePath);
        $fileSystem->remove($filePath);
        return $saveDbPath;
    }

    public function actionList() {
        $flag = true;
        $object = Yii::app()->request->getParam('object',"");
        $collect_id = Yii::app()->request->getParam('collect_id',"");
        if (Yii::app()->getRequest()->ispostRequest) {
            if($object == "collection"){
				$flag = false;
				$rbtList = Yii::app()->request->getParam('cid');
				AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $rbtList,'rbt');
			} else{
                $flag = false;
                $rtList = Yii::app()->request->getParam('cid');
                AdminFeatureRingtoneModel::model()->addList($this->userId, $rtList);
            }
        }

        if ($flag) {
            $categoryList = AdminGenreModel::model()->gettreelist(2);
            $cpList = AdminCpModel::model()->findAll();
            $pageSize = Yii::app()->request->getParam('pageSize', 20);
            Yii::app()->user->setState('pageSize', $pageSize);
            $model = new RingtoneModel('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RingtoneModel'])) {
                $model->attributes = $_GET['RingtoneModel'];
            }
            $model->setAttribute("status", RingtoneModel::ACTIVE);
            $model->setAttribute("sync_status", 1);

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('list', array(
                'model' => $model,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                'object' => $object,
                'collect_id' => $collect_id
                    ), false, true);
        }
    }

}
