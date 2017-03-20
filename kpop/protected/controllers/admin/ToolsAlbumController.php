<?php
Yii::import("ext.xupload.models.XUploadForm");
class ToolsAlbumController extends Controller
{
	public $type = AdminAlbumModel::ALL;
	public $albumArtist = array();
	public function init() {
		parent::init();
		$this->pageTitle = Yii::t('admin', 'Quản lý album');
		$type = Yii::app()->request->getParam('AdminAlbumModel');
		$this->type = isset($type['status']) ? $type['status'] : AdminAlbumModel::ALL;
	}
	
	public function actions() {
		return array(
				'upload' => array(
						'class' => 'ext.xupload.actions.XUploadAction',
						'subfolderVar' => 'parent_id',
						'path' => _APP_PATH_ . DS . "data",
						'alowType' => 'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg'
				),
		);
	}
	
	public function actionPopupList()
	{
		$flag=true;
		
		$index =  Yii::app()->request->getParam('index',0);
		$id_dialog = 'p_'.$index;
		$type = Yii::app()->request->getParam('type',0);
		if($type==2){
			$id_field =  'composer_ids_'.$index;
			$view = 'popupListCom';
		}else{
			$id_field =  'artist_ids_'.$index;
			$view = 'popupList';
		}
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
		}
	
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$model = new AdminArtistModel('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['AdminArtistModel']))
				$model->attributes=$_GET['AdminArtistModel'];
			$model->setAttribute("status", ArtistModel::ACTIVE);
	
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial($view,array(
					'model'=>$model,
					'id_field'=>$id_field,
					'id_dialog'=>$id_dialog,
					'index'=>$index
			),false,true);
			Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
		}
	}
	public function actionReloadSong()
	{
		//$model = $this->loadModel($id);
		$albumId = Yii::app()->request->getParam('album_id');
		$songList = AdminAlbumSongModel::model()->findAll("album_id=".$albumId);
			$this->renderPartial('_songInList', array(
					//'model' => $model,
					'songList' => $songList,
					'id' => $albumId
			),false, true);
	}
	public function actionPopupSong()
	{
		$albumId = Yii::app()->request->getParam('album_id');
		Yii::app()->user->setState('pageSize', 20);
		$songModel = new AdminSongModel('search');
		$songModel->unsetAttributes();
		
		if (isset($_GET['AdminSongModel'])) {
			$songModel->attributes = $_GET['AdminSongModel'];
		}
		
		//$songModel->setAttribute("status", "<>".AdminSongModel::DELETED);
		$songModel->setAttribute("status", 1);
		$lyric = 2;
		if (isset($_GET['lyric'])) {
			$lyric = $_GET['lyric'];
		}
		$songModel->lyric = $lyric;
		
		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$this->renderPartial('_addItems', array(
				'songModel' => $songModel,
				'album_id' => $albumId,
				'lyric'=>$lyric,
				'categoryList' => $categoryList,
				'cpList' => $cpList,
		), false, true);
	}
	public function actionAddItem()
	{
		$contentId = Yii::app()->request->getParam('sid');
		$albumId = Yii::app()->request->getParam('album_id');
		$songInAlbum = AdminAlbumSongModel::model()->findAll("album_id=:ALBUMID", array(':ALBUMID' => $albumId));
		$songData = CHtml::listData($songInAlbum, 'id', 'song_id');
		if(is_array($contentId) && count($contentId)>0){
			for ($i = 0; $i < count($contentId); $i++) {
				if (!in_array($contentId[$i], $songData)) {
					$model = new AdminAlbumSongModel();
					$model->song_id = $contentId[$i];
					$model->album_id = $albumId;
					$model->save();
				}
			}
			echo 'Đã thêm bài hát vào album';
		}else{
			echo 'Chưa chọn bài hát nào';
		}
		Yii::app()->end();
	}
	public function actionRemoveItem()
	{
		$id = yii::app()->request->getparam('id');
		$albumId = yii::app()->request->getparam('album_id');
		$condition = "id=$id";
		AdminAlbumSongModel::model()->deleteAll($condition);
		AdminAlbumModel::model()->updateTotalSong($albumId);
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
	public function actionIndex()
	{
		//
	}
	public function actionUploadFile()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$pathUploadTmp = _APP_PATH_ . DS . "data".DS."tmp".DS;
		$allowedExtensions = array("mp3");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 100 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($pathUploadTmp);
		
		
		$fileSize=filesize($pathUploadTmp.$result['filename']);//GETTING FILE SIZE
		$fileName=$result['filename'];//GETTING FILE NAME
		
		if(isset($_SESSION['li_index'])){
			$liIndex = $_SESSION['li_index']+1;
		}else{
			$liIndex = 1;
		}
		$_SESSION['li_index'] = $liIndex;
		$params = array(
				'index'=>$liIndex,
				'fileName'=>$fileName,
				'error'=>(isset($result['success']) && $result['success'])?"":$result['error'],
				'rawname'=>isset($result['rawname'])?$result['rawname']:''
		);
		
		$result['data'] = $this->renderPartial('_response_upload', $params, true, false);
		$return = CJSON::encode($result);
		echo $return;// it's array
	}
	public function actionSaveAlbum()
	{
		$albumId = $_POST['albumId'];
		try{
		if($albumId>0){
			//update
			$id=$albumId;
			$model = $this->loadModel($id);
			$albumMeta = AdminAlbumMetadataModel::model()->findByPk($id);
			if (empty($albumMeta)) {
				$albumMeta = new AdminAlbumMetadataModel();
				$albumMeta->album_id = $id;
			}
			
			$model->attributes = $_POST['AdminAlbumModel'];
			
			$model->setAttributes(array(
					'updated_time' => date("Y-m-d H:i:s"),
			));
			$albumMeta->attributes = $_POST['albumMeta'];
			AdminAlbumArtistModel::model()->updateArtist($model->id, $_POST['AdminAlbumModel_artist_id_list']);
			$model->artist_name = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id, 'name');
			if ($model->save()) {
				$fileAvatar = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $_POST['AdminAlbumModel']['source_path'];
				if (file_exists($fileAvatar)) {
					AvatarHelper::processAvatar($model, $fileAvatar);
				}
			
				//Update Album meta
				$albumMeta->save();
			
				//UPDATE ALBUM STATUS TO  APPROVED
				if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::APPROVED) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setApproved($listAlbum, $this->userId);
				} else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::WAIT_APPROVED) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setWaitApproved($listAlbum, $this->userId);
				} else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::REJECT) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setDelete($listAlbum, $this->userId);
				}
				//success
				echo CJSON::encode(array(
						'error_code'=>0,
						'album_id'=>$id,
						'error_msg'=>'Đã cập nhật thông tin Album | '.date('Y-m-d H:i:s'),
				));
				Yii::app()->end();
			}
			
		}else{
			//insert
			$model = new AdminAlbumModel;
			$albumMeta = new AdminAlbumMetadataModel();
			/* echo '<pre>';print_r($_POST);
			 die(); */
			$msg='';
			if(empty($_POST['AdminAlbumModel']['name'])){
				$msg .= "Chưa nhập tên album";
				echo CJSON::encode(array(
						'error_code'=>1,
						'error_msg'=>$msg
				));
				Yii::app()->end();
			}
			
			if(!isset($_POST['AdminAlbumModel_artist_id_list']) || (count($_POST['AdminAlbumModel_artist_id_list'])<=0 && isset($_POST['AdminAlbumModel_artist_id_list']))){
				$error_code=1;
				$msg .= "Phải chọn ít nhất 1 ca sỹ";
				echo CJSON::encode(array(
						'error_code'=>$error_code,
						'error_msg'=>$msg
				));
				Yii::app()->end();
			}
			$cpId = $this->cpId;
			if ($cpId == 0) {
				$cpId = $_POST['AdminAlbumModel']['cp_id'];
			}
			$model->attributes = $_POST['AdminAlbumModel'];
			$model->setAttributes(
					array(
							'created_time' => date("Y-m-d H:i:s"),
							'updated_time' => date("Y-m-d H:i:s"),
							'price' => Yii::app()->params['price']['albumListen'],
							'cp_id' => $cpId,
					));
			
			$albumMeta->attributes = $_POST['albumMeta'];
			
			if ($model->save()) {
				$fileAvatar = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $_POST['AdminAlbumModel']['source_path'];
				if (file_exists($fileAvatar)) {
					AvatarHelper::processAvatar($model, $fileAvatar);
				}
			
				//Update Album meta
				$albumMeta->save();
				AdminAlbumArtistModel::model()->updateArtist($model->id, $_POST['AdminAlbumModel_artist_id_list']);
				$model->artist_name = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id, 'name');
				$model->save();
			
				//success
				echo CJSON::encode(array(
						'error_code'=>0,
						'album_id'=>$model->id,
						'error_msg'=>'Đã thêm mới Album'
				));
				Yii::app()->end();
			}
		}
		}catch (Exception $e)
		{
			echo CJSON::encode(array(
					'error_code'=>1,
					'album_id'=>$model->id,
					'error_msg'=>'Exception: '.$e->getMessage()
			));
			Yii::app()->end();
		}
	}
	public function actionAddSong()
	{
		//
		$index = Yii::app()->request->getParam('index',0);
		$albumId = Yii::app()->request->getParam('albumId',0);
		$dataSongStr = Yii::app()->request->getParam('dataSong','');
		$cp_id = Yii::app()->request->getParam('cpId',0);
		$genreId = Yii::app()->request->getParam('genreId',0);
		$dataSong = urldecode($dataSongStr);
		$dataSong = explode('&', $dataSong);
		$songName = $songFile = "";
		$songArtistId = array();
		$songComposerId = "";
		if(count($dataSong)>0){
			foreach ($dataSong as $value){
				if(strpos($value, 'song_name')!==false){
					$songName = str_replace('songInfo['.$index.'][song_name]=', '', $value);
				}elseif(strpos($value, 'song_file')!==false){
					$songFile = str_replace('songInfo['.$index.'][song_file]=', '', $value);
				}elseif(strpos($value, 'arids')!==false){
					$songArtistId[] = str_replace('songInfo['.$index.'][arids][]=', '', $value);
				}elseif(strpos($value, 'comid')!==false){
					$songComposerId = str_replace('songInfo['.$index.'][comid]=', '', $value);
				}
			}
		}
		if(empty($songName) || empty($songFile)){
			echo CJSON::encode(array(
					'error_id'=>1,
					'error_msg'=>"Chưa nhập đủ thông tin bài hát!",
			));
			Yii::app()->end();
		}
		if(count($songArtistId)<=0){
			$sql = "SELECT artist_id FROM album_artist WHERE album_id=:alid";
			$cm = Yii::app()->db->createCommand($sql);
			$cm->bindParam(':alid', $albumId, PDO::PARAM_INT);
			$songArtistArr = $cm->queryAll();
			if(count($songArtistArr)>0){
				foreach ($songArtistArr as $value){
					$songArtistId[]=$value['artist_id'];
				}
			}
		}
		//add song
		if (true) {
			$model = new AdminSongModel;
			// set default value
			$defaultValue = array(
					'allow_download' => 1,
					'download_price' => Yii::app()->params['price']['songDownload'],
					'listen_price' => Yii::app()->params['price']['songListen']
			);
			$model->setAttributes($defaultValue);
			
			$adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
			$cpId = $adminUser->cp_id;
			if ($cpId == 0 || $cpId == '0' || !isset($cpId)) {
				$cpId = $cp_id;
			}
			$error_msg="";
			if ($cpId == 0 || $cpId == '0' || !isset($cpId)) {
				$error_msg = Yii::t('admin', 'Tài khoản chưa được gán quyền CP');
				echo CJSON::encode(array(
					'error_id'=>1,
					'error_msg'=>$error_msg,
				));
				Yii::app()->end();
			}
			$songCode = AdminAdminUserModel::model()->getMaxContentCode($cpId, 'song');
		
			if (!$songCode) {
				$error_msg = Yii::t('admin', 'Tài khoản đã hết quyền upload bài hát');
				echo CJSON::encode(array(
					'error_id'=>1,
					'error_msg'=>$error_msg,
				));
				Yii::app()->end();
			}
			
			$songexits = AdminSongModel::model()->findAllByAttributes(array('name' => $songName));
			$isExits = false;
			$hadsong = null;
			if($songexits){
				foreach ($songexits as $songexit) {
					if ($songexit->cp_id == $cpId && $songexit->songstatus->approve_status <> 2) {
						$tmp = array();
						foreach($songexit->song_artist as $artist){
							$tmp[] = $artist->artist_id;
						}
						sort($tmp);
						sort($songArtistId);
						if($tmp == $songArtistId){
							$isExits = true;
							$hadsong = $songexit;
							break;
						}
					}
				}
			}
			$urlKey = Common::makeFriendlyUrl($songName);
			$data = array(
					'name'=>$songName,
					'code' => $songCode,
	            	'url_key' => $urlKey,
	                'created_time' => date("Y-m-d H:i:s"),
	                'updated_time' => date("Y-m-d H:i:s"),
	                'created_by' => $this->userId,
	            	'composer_id' => 0,
	                'cp_id' => $cpId,
	            	'max_bitrate'=>0,
					'allow_download' => 1,
					'download_price' => Yii::app()->params['price']['songDownload'],
					'listen_price' => Yii::app()->params['price']['songListen'],
	            	'owner' =>'',
	            	'copyright' => 0,
	            	'source' =>'',
	            	'source_link' =>'',
			);
		
			// can edit price
			$model->attributes = $data;
			$model->setAttributes($data);
			$model->setAttribute('composer_id', $songComposerId);
			//$model->unsetAttributes('source_path');
			
			//check exits file
			$fileMp3 = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $songFile;
		
			if (file_exists($fileMp3) && !$isExits) {
				if ($model->save()) {
					$songIdInsert = $model->id;
					$this->moveFile($model, $fileMp3);
					//Create Convert Song
					$songlist[] = $model->id;
					AdminConvertSongModel::model()->updateStatus($songlist, AdminConvertSongModel::NOT_CONVERT);
		
					//Update groupID
					AdminSongModel::model()->updateSongGroupId($model, $songArtistId);
		
					//update song extra
					$this->updateSongExtra($songIdInsert, "");
		
					//Update songCate
					AdminSongGenreModel::model()->updateSongCate($model->id, array($genreId));
		
					//Update songartist
					AdminSongArtistModel::model()->updateArtist($model->id, $songArtistId);
					$model->artist_name = AdminSongArtistModel::model()->getArtistBySong($model->id, 'name');
					$model->save();
					
					//update song to album
					$songInAlbum = AdminAlbumSongModel::model()->findAll("album_id=:ALBUMID", array(':ALBUMID' => $albumId));
					$modelAlbumSong = new AdminAlbumSongModel();
					$modelAlbumSong->song_id = $songIdInsert;
					$modelAlbumSong->album_id = $albumId;
					$updateAlbum = $modelAlbumSong->save();
					
					$sdfasdf = AdminAlbumModel::model()->updateTotalSong($albumId);
					echo CJSON::encode(array(
							'error_id'=>0,
							'songId'=>CJSON::encode($songlist),
							'error_msg'=>"Success!",
					));
					Yii::app()->end();
				}
			} else {
				if(!file_exists($fileMp3))
					$error_msg .= 'Chưa upload file'."\n";
				if($isExits)
					$error_msg = 'Hệ thống đã tồn tại bài hát cùng tên và cùng CP với bài bạn muốn Upload lên!';
			}
		}
		if(empty($error_msg)){
			echo CJSON::encode(array(
					'error_id'=>0,
					'error_msg'=>"Success!",
			));
		}else{
			echo CJSON::encode(array(
					'error_id'=>1,
					'error_msg'=>$error_msg,
			));
		}
		
		
		Yii::app()->end();
		//echo '<pre>';print_r($dataSong);
	}
	protected function moveFile($model, $filePath) {
		$saveFilePath = $model->getSongOriginPath($model->id);
		$saveDbPath = $model->getSongOriginPath($model->id, false);
		$fileSystem = new Filesystem();
	
		$ret = $fileSystem->copy($filePath, $saveFilePath);
		$model->source_path = $saveDbPath;
		$model->save();
		if ($this->userId == 14) {
			Yii::log("Copy file $filePath: $saveFilePath", "error");
		}
		$fileSystem->remove($filePath);
		if (!$ret) {
			Yii::log("Khong copy duoc file $filePath: $saveFilePath", "error");
		}
		return $saveDbPath;
	}
	protected function updateSongExtra($songId, $lyric)
	{
		$sql = "SELECT count(*) FROM song_extra WHERE song_id = $songId";
		$exists = Yii::app()->db->createCommand($sql)->queryScalar();
		if($exists>0){
			$sql = "UPDATE song_extra set lyrics = :lyric WHERE song_id=:sid";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':lyric', $lyric, PDO::PARAM_STR);
			$command->bindParam(':sid', $songId, PDO::PARAM_INT);
			$command->execute();
		}else{
			$sql = "INSERT INTO song_extra(song_id, lyrics) VALUE(:sid, :lyric)";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':lyric', $lyric, PDO::PARAM_STR);
			$command->bindParam(':sid', $songId, PDO::PARAM_INT);
			$command->execute();
		}
	}
	public function actionDeleteSong(){
		
	}
	public function actionCreate()
	{
		
		if(isset($_SESSION['li_index'])) unset($_SESSION['li_index']);
		$model = new AdminAlbumModel;
        $albumMeta = new AdminAlbumMetadataModel();
        
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
        $this->render('create', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            'cpList' => $cpList,
            'albumMeta' => $albumMeta
        ));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
		$albumMeta = AdminAlbumMetadataModel::model()->findByPk($id);
		if (empty($albumMeta)) {
			$albumMeta = new AdminAlbumMetadataModel();
			$albumMeta->album_id = $id;
		}
	
		if ($model->albumstatus->approve_status == AdminAlbumStatusModel::REJECT) {
			$this->forward("album/view", true);
		}
		//$beforeArtist = $model->artist_id;
	
		if (isset($_POST['AdminAlbumModel'])) {
			$model->attributes = $_POST['AdminAlbumModel'];
			//$artistList = $_POST['AdminAlbumModel']['artist_id_list'];
			//$artist_id = $artistList[0];
			//$artistModel = AdminArtistModel::model()->findByPk($artist_id);
			//$artist_name = empty($artistModel)?"":$artistModel->name;
	
			$model->setAttributes(array(
					'updated_time' => date("Y-m-d H:i:s"),
					//'artist_id' => $artist_id,
					//'artist_name' => $artist_name,
			));
			$albumMeta->attributes = $_POST['albumMeta'];
			AdminAlbumArtistModel::model()->updateArtist($model->id, $_POST['AdminAlbumModel_artist_id_list']);
			$model->artist_name = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id, 'name');
			if ($model->save()) {
				$fileAvatar = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $_POST['AdminAlbumModel']['source_path'];
				if (file_exists($fileAvatar)) {
					AvatarHelper::processAvatar($model, $fileAvatar);
				}
	
				//Update Album meta
				$albumMeta->save();
	
				//UPDATE ALBUM STATUS TO  APPROVED
				if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::APPROVED) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setApproved($listAlbum, $this->userId);
				} else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::WAIT_APPROVED) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setWaitApproved($listAlbum, $this->userId);
				} else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::REJECT) {
					$listAlbum[] = $id;
					AdminAlbumModel::model()->setDelete($listAlbum, $this->userId);
				}
	
				//CHANGE ARTISTID & ARTIST_STATUS
				/*
				 $afterAritst = $model->artist_id;
				if ($beforeArtist != $afterAritst) {
				$albumStatusModel = AdminAlbumStatusModel::model()->findByPk($model->id);
				$albumStatusModel->artist_status = AdminAlbumStatusModel::ARTIST_PUBLISH;
				$albumStatusModel->artist_id = $model->artist_id;
				$albumStatusModel->save();
				}
	
				*/
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
	
		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$uploadModel = new XUploadForm();
		$cpList = AdminCpModel::model()->findAll();
		$this->albumArtist = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id);
		$this->render('update', array(
				'model' => $model,
				'categoryList' => $categoryList,
				'uploadModel' => $uploadModel,
				'cpList' => $cpList,
				'albumMeta' => $albumMeta
		));
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$metaModel = AdminAlbumMetadataModel::model()->findByPk($id);
		$this->render('view', array(
				'model' => $this->loadModel($id),
				'metaModel' => $metaModel
		));
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-album-model-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = AdminAlbumModel::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}