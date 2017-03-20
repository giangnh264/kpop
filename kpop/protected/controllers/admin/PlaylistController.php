<?php

Yii::import("ext.xupload.models.XUploadForm");

class PlaylistController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  Playlist");
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => Yii::app()->params['storage']['staticDir'],
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        /*
          $this->slidebar=array(
          array('label'=>yii::t('admin', 'Danh sách playlist'), 'url'=>array('/playlist/index'),"active"=>"active"),
          array('label'=>yii::t('admin', 'Playlist chọn lọc'), 'url'=>array('/playlistFeature/index')),
          );

         */

        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminPlaylistModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminPlaylistModel'])) {
            $model->attributes = $_GET['AdminPlaylistModel'];
            if (isset($_GET['AdminPlaylistModel']['created_time']) && $_GET['AdminPlaylistModel']['created_time'] != "") {
                // Re-setAttribute create datetime
                $createdTime = $_GET['AdminPlaylistModel']['created_time'];
                if (strrpos($createdTime, "-")) {
                    $createdTime = explode("-", $createdTime);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['AdminPlaylistModel']['created_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['AdminPlaylistModel']['created_time'])) . " 23:59:59";
                }
                $model->setAttribute("created_time", array(0 => $fromDate, 1 => $toDate));
            }
        }


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
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Thông tin cơ bản'), 'url'=>'#',"active"=>"active",'linkOptions'=>array('id'=>'basic-info')),
          array('label'=>Yii::t('admin', 'Danh sách bài hát'), 'url'=>array('playlist/songList','id'=>$id),'linkOptions'=>array('id'=>'inlist-info',)),
          array('label'=>Yii::t('admin', 'Danh sách yêu thích'), 'url'=>array('playlist/favList','id'=>$id),'linkOptions'=>array('id'=>'fav-info')),
          array('label'=>Yii::t('admin', 'Meta data'), 'url'=>'#','linkOptions'=>array('id'=>'meta-info')),
          );
         */
        $metaModel = AdminPlaylistMetadataModel::model()->findByPk($id);
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'metaModel' => $metaModel
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Thông tin cơ bản'), 'url'=>'#',"active"=>"active",'linkOptions'=>array('id'=>'basic-info')),
          array('label'=>Yii::t('admin', 'Meta data'), 'url'=>'#','linkOptions'=>array('id'=>'meta-info')),
          );
         */
        $model = new AdminPlaylistModel;
        $playlistMeta = new AdminPlaylistMetadataModel();

        if (isset($_POST['AdminPlaylistModel'])) {
            $model->attributes = $_POST['AdminPlaylistModel'];
            $model->setAttribute("created_time", date("Y-m-d h:i:s"));
            $model->setAttribute("updated_time", date("Y-m-d h:i:s"));
            if (isset($_POST['AdminPlaylistModel']['user_id']) && $_POST['AdminPlaylistModel']['user_id'] != 0) {
                $user = AdminUserModel::model()->findByPk($_POST['AdminPlaylistModel']['user_id']);
                if ($user)
                    $model->setAttribute("username", $user->username);
            }
            if ($model->save()) {
                //$fileAvatar = Yii::app()->params['storage']['staticDir'].DS."tmp".DS.$_POST['AdminPlaylistModel']['source_path'];
                //AvatarHelper::processAvatar($model, $fileAvatar);
                //Update Playlist meta
                $playlistMeta->attributes = $_POST['playlistMeta'];
                $playlistMeta->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $uploadModel = new XUploadForm();
        $this->render('create', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'playlistMeta' => $playlistMeta,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Thông tin cơ bản'), 'url'=>'#',"active"=>"active",'linkOptions'=>array('id'=>'basic-info')),
          array('label'=>Yii::t('admin', 'Danh sách bài hát'), 'url'=>array('playlist/songList','id'=>$id),'linkOptions'=>array('id'=>'inlist-info',)),
          array('label'=>Yii::t('admin', 'Danh sách yêu thích'), 'url'=>array('playlist/favList','id'=>$id),'linkOptions'=>array('id'=>'fav-info')),
          array('label'=>Yii::t('admin', 'Meta data'), 'url'=>'#','linkOptions'=>array('id'=>'meta-info')),
          );
         */
        $model = $this->loadModel($id);
        $playlistMeta = AdminPlaylistMetadataModel::model()->findByPk($id);
        if (empty($playlistMeta)) {
            $playlistMeta = new AdminPlaylistMetadataModel();
            $playlistMeta->playlist_id = $id;
        }
        if (isset($_POST['AdminPlaylistModel'])) {
            $model->attributes = $_POST['AdminPlaylistModel'];
            $model->setAttribute("updated_time", date("Y-m-d h:i:s"));
            if (($_POST['AdminPlaylistModel']['user_id']) && $_POST['AdminPlaylistModel']['user_id'] != 0) {
                $user = AdminUserModel::model()->findByPk($_POST['AdminPlaylistModel']['user_id']);
                if ($user)
                    $model->setAttribute("username", $user->username);
            }

            if ($model->save()) {
                /*
                  $fileAvatar = Yii::app()->params['storage']['staticDir'].DS."tmp".DS.$_POST['AdminPlaylistModel']['source_path'];
                  if(file_exists($fileAvatar)){
                  AvatarHelper::processAvatar($model, $fileAvatar);
                  }
                 */

                //Update Playlist meta
                $playlistMeta->attributes = $_POST['playlistMeta'];
                $playlistMeta->save();

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $uploadModel = new XUploadForm();
        $this->render('update', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'playlistMeta' => $playlistMeta,
        ));
    }

    /**
     * Copy record
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be copy
     */
    public function actionCopy($id) {
        /*
          $this->slidebar=array(
          array('label'=>Yii::t('admin', 'Thông tin cơ bản'), 'url'=>'#',"active"=>"active",'linkOptions'=>array('id'=>'basic-info')),
          array('label'=>Yii::t('admin', 'Meta data'), 'url'=>'#','linkOptions'=>array('id'=>'meta-info')),
          );
         */
        $model = $this->loadModel($id);
        $playlistMeta = AdminPlaylistMetadataModel::model()->findByPk($id);
        if (empty($playlistMeta)) {
            $playlistMeta = new AdminPlaylistMetadataModel();
            $playlistMeta->playlist_id = $id;
        }
        if (isset($_POST['AdminPlaylistModel'])) {
            $model = new AdminPlaylistModel;
            $model->attributes = $_POST['AdminPlaylistModel'];
            $model->setAttribute("updated_time", date("Y-m-d h:i:s"));
            if (($_POST['AdminPlaylistModel']['user_id']) && $_POST['AdminPlaylistModel']['user_id'] != 0) {
                $user = AdminUserModel::model()->findByPk($_POST['AdminPlaylistModel']['user_id']);
                if ($user)
                    $model->setAttribute("username", $user->username);
            }

            if ($model->save()) {
                /*
                  $fileAvatar = Yii::app()->params['storage']['staticDir'].DS."tmp".DS.$_POST['AdminPlaylistModel']['source_path'];
                  if(file_exists($fileAvatar)){
                  AvatarHelper::processAvatar($model, $fileAvatar);
                  }
                 */

                //Update Playlist meta
                $playlistMeta->attributes = $_POST['playlistMeta'];
                $playlistMeta->save();

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $uploadModel = new XUploadForm();
        $this->render('update', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
            'playlistMeta' => $playlistMeta,
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
            AdminPlaylistModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            AdminPlaylistModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    public function actionSongList($id) {
        $playlistSong = new AdminPlaylistSongModel('search');
        $playlistSong->unsetAttributes();
        $playlistSong->setAttribute('playlist_id', $id);
        $this->renderPartial('_songInList', array('listSong' => $playlistSong, 'id' => $id));
    }

    public function actionPublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 0;
        $condition = "id IN ($items)";
        AdminPlaylistSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionUnpublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 1;
        $condition = "id IN ($items)";
        AdminPlaylistSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionAddItems() {
        $flag = true;
        $playListId = Yii::app()->request->getparam('playlis_id');
        if (Yii::app()->getRequest()->ispostRequest) {
            $flag = false;
            $songInPlaylist = AdminPlaylistSongModel::model()->findAll("playlist_id=:PID", array(':PID' => $playListId));
            $songData = CHtml::listData($songInPlaylist, 'id', 'song_id');
            $contentId = Yii::app()->request->getParam('cid');
            for ($i = 0; $i < count($contentId); $i++) {
                if (!in_array($contentId[$i], $songData)) {
                    $model = new AdminPlaylistSongModel();
                    $model->song_id = $contentId[$i];
                    $model->playlist_id = $playListId;
                    if (!$model->save()) {
                        $error = $model->geterrors();
                        echo "<pre>";
                        print_r($error);
                        exit();
                    }
                }
            }
        }
        if ($flag) {
            Yii::app()->user->setState('pageSize', 20);
            $songModel = new AdminSongModel('search');
            $songModel->unsetAttributes();
            $songModel->setAttribute('status', AdminSongModel::ACTIVE);
            if (isset($_GET['AdminSongModel'])) {
                $songModel->attributes = $_GET['AdminSongModel'];
            }

            $categoryList = AdminGenreModel::model()->gettreelist(2);
            $cpList = AdminCpModel::model()->findAll();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_addItems', array(
                'songModel' => $songModel,
                'playListId' => $playListId,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                    ), false, true);
        }
    }

    public function actionReorderItems() {
        $data = Yii::app()->request->getParam('sorder');
        foreach ($data as $k => $v) {
            if (isset($v) && $v != "") {
                $playlistSong = AdminPlaylistSongModel::model()->findByPk($k);
                $playlistSong->sorder = $v;
                $playlistSong->save();
            }
        }
    }

    public function actionDeleteItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $condition = "id IN ($items)";
        AdminPlaylistSongModel::model()->deleteAll($condition);
    }

    public function actionFavList($id) {
        $favlist = new AdminFavouritePlaylistModel('search');
        $favlist->unsetAttributes();
        $favlist->setAttribute('playlist_id', $id);
        $this->renderPartial('_favList', array('favlist' => $favlist, 'id' => $id));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminPlaylistModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-playlist-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
