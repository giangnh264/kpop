<?php
@ini_set("display_errors", 0);
Yii::import("ext.xupload.models.XUploadForm");

class ImportsongController extends Controller {

    const START_ROW = 1;
    const NUMBER_ROW_LIMIT = 999;
    const IMPORT_SONG_CACHE = 'Importer_';
	const PATH_FILE_SOURCE = "";
    public function actions() {
    	$path = _APP_PATH_ . DS . "data";
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => $path,
                'alowType' => 'application/vnd.ms-excel,excel/xls')
        );
    }

    public function actionIndex() {
        $result = Yii::app()->cache->delete(self::IMPORT_SONG_CACHE . Yii::app()->user->id);
        $this->render('index');
    }

    public function actionNewimport() {
    	die('not found!');
    	//$path = _APP_PATH_ . DS . "data";
    	$pathSource = 'E:\phuongnv\Vega\chacha_cloud\src\trunk\chacha\data';
    	//$_GET['msg'] = Yii::t('admin','Chức năng import tạm thời dừng để nâng cấp hệ thống');
    	//$this->forward("admin/error",true);
		try{
			$log = new KLogger('LOG_IMPORT_FILE_SONG_PNV', KLogger::INFO);
			$log->LogInfo("Start New Import", false);
	        $model = new AdminImportSongModel;
	        $importer = self::IMPORT_SONG_CACHE . Yii::app()->user->id;
	        $result = array();
	
	        if (isset($_POST['AdminImportSongModel'])) {
	            $autoconfirm = Yii::app()->request->getParam('autoconfirm');
	            $autoconfirm = isset($autoconfirm) ? 1 : 0;
	
	            $created_time = $_POST['AdminSongModel']['created_time'];
	            $updated_time = $_POST['AdminSongModel']['updated_time'];
	
	            $path = Yii::app()->params['importsong']['store_path'];
	            $file_path = $pathSource . DS . "tmp" . DS . $_POST['AdminImportSongModel']['source_path'];
	            $fileName = explode(DS, $file_path);
	            $fileName = $fileName[count($fileName)-1];
	            if (file_exists($file_path)) {
	                $count = 0;
	                $start_row = $_POST['AdminImportSongModel']['start_row'] > 0 ? $_POST['AdminImportSongModel']['start_row'] : 0;
	                $start_row += self::START_ROW;
	                $limit_row = $_POST['AdminImportSongModel']['limit_row'] < 1001 ? $_POST['AdminImportSongModel']['limit_row'] : 1000;
	                $limit_row += $start_row;
	                $log->LogInfo("Start Read File and put Memcache | ".$file_path, false);
	                $data = new ExcelReader($file_path);
	                $resultSql = array();
	                //insert file
	                $sql = "INSERT INTO import_song_file(file_name,importer,status,created_time)
                			VALUE('".mysql_real_escape_string($fileName)."', '{$importer}',0,NOW())
	                                			";
	                $insertFileRess = Yii::app()->db->createCommand($sql)->execute();
	                $fileImportId = Yii::app()->db->getLastInsertID();
	                for ($i = $start_row; $i < $limit_row; $i++) {
	                    if ($data->val($i, 'B') != "" && $data->val($i, 'G') != "" && $data->val($i, 'C') != "") {
	                    	$stt = $data->val($i, Yii::app()->params['importsong']['excelcolumns']['stt']);
	                    	$name= $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['name']));
	                    	$category = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['category']));
	                    	$sub_category = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['sub_category']));
	                    	$composer = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['composer']));
	                    	$artist = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['artist']));
	                    	$album = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['album']));
	                    	$path = str_replace('\\', DS, $data->val($i, Yii::app()->params['importsong']['excelcolumns']['path']));
	                    	$file = $data->val($i, Yii::app()->params['importsong']['excelcolumns']['file']);
	                        
	                    	$sql = "(";
	                        $sql .= "'".($autoconfirm)."'"; 
	                        $sql .= ",'".$created_time."'";
	                        $sql .= ",'".$updated_time."'";
	                        $sql .= ",'".$stt."'";
	                        $sql .= ",'".$name."'";
	                        $sql .= ",'".$category."'";
	                        $sql .= ",'".$sub_category."'";
	                        $sql .= ",'".$composer."'";
	                        $sql .= ",'".$artist."'";
	                        $sql .= ",'".$album."'";
	                        $sql .= ",'".mysql_real_escape_string($path)."'";
	                        $sql .= ",'".mysql_real_escape_string($file)."'";
	                        $sql .= ",'".$importer."'";
	                        $sql .= ",'".mysql_real_escape_string($file_path)."'";
	                        $sql .= ",'".$fileImportId."'";
	                        $sql .= ")";
	                        $resultSql[]=$sql;
	                        $count++;
	                    }
	                    /* if($count==10)
	                    	echo '<pre>';print_r($result);die(); */
	                }
	                
	                //insert data to db
	                if($insertFileRess){
		                $sql = "INSERT INTO import_song(autoconfirm,created_time,updated_time,stt,name,category,sub_category,composer,artist,album,path,file,importer,file_name,file_id) VALUES";
		                $sql .= implode(',', $resultSql);
		                Yii::app()->db->createCommand($sql)->execute();
		                	//insert false
		                
	                }
	                
	                
	                //remove file source after insert
	                $fileSystem = new Filesystem();
	                $fileSystem->remove($file_path);
	
	                if ($_POST['AdminImportSongModel']['ajax'])
	                    echo json_encode(array('not_exist_file' => 0,'total_record'=>count($resultSql)));
	                exit();
	            } else {
	                if ($_POST['AdminImportSongModel']['ajax'])
	                    $data = $this->renderPartial('ajaxerror', array('errormess' => 'Có lỗi xảy ra <br> - Chưa upload file excel'), true, true);
	                echo json_encode(array('not_exist_file' => 1, 'data' => $data,'total_record'=>count($result)));
	                exit();
	            }
	        }
		}catch (Exception $e)
		{
			$log->LogError("actionAjaxImport | Exception Error: ".$e->getMessage(), false);
		}
        $uploadModel = new XUploadForm();
        $this->render('newimport', array(
            'model' => $model,
            'listSong' => $result,
            'uploadModel' => $uploadModel,
        ));
    }

    public function actionAjaxImport() {
    	try{
    		$log = new KLogger('LOG_IMPORT_FILE_SONG_PNV', KLogger::INFO);
    		$log->LogInfo("Start Ajax Import",false);
        	$model = new AdminImportSongModel;
        	$keyMemcache = self::IMPORT_SONG_CACHE . Yii::app()->user->id;
	        $result = Yii::app()->cache->get($keyMemcache);
	        $path = Yii::app()->params['importsong']['store_path'];
	        $is_error = 1;
	        $imported = array();
	        $notImport = array();
			$log->LogInfo("Start get Cache Key | ".$keyMemcache, false);
	        if ($result && count($result) > 0) {
	            Yii::app()->session['import_init'] = Yii::app()->session['import_init'] + 1;
	            $index_import = Yii::app()->session['import_init'];
	            $status = 0;
	            if (Yii::app()->session['import_number'] <= $index_import)
	                $success = 1;
	
	            $index_import = $index_import - 1;
	            $insert_id = $model->importSong($result[$index_import], $path);
	
	            // save inserted id to a string, for updating Updated_time column when finish
	            if ($index_import == 0)
	                unset(Yii::app()->session['inserted_id']);
	            Yii::app()->session['inserted_id'] .= "," . $insert_id;
	
	            if ($insert_id > 0 && !in_array($insert_id, array(2,3,4))) {
	                Yii::app()->session['imported_count']++;
	                $imported = array('stt' => $result[$index_import]['stt'], 'name' => $result[$index_import]['name'], 'path' => $result[$index_import]['path']);
	                $is_error = 0;
	                $log->LogInfo('Success | '.json_encode($imported), false);
	            } else {
	                $model->saveLogFile('Not import > (' . $result[$index_import]['stt'] . ')' . $result[$index_import]['path'] . $result[$index_import]['file']);
	                if (empty(Yii::app()->session['import_error'])) {
	                    Yii::app()->session['import_error'] = 0;
	                }
	                Yii::app()->session['import_error'] = Yii::app()->session['import_error'] + 1;
	                $count_error = Yii::app()->session['import_error'];
	                $is_error = 1;
	                $notImport = array('stt' => $result[$index_import]['stt'], 'name' => $result[$index_import]['name'], 'path' => $result[$index_import]['path']);
	            	$log->LogInfo('Not import > (' . $result[$index_import]['stt'] . ')' . $result[$index_import]['path'] . $result[$index_import]['file'], false);
	            }
	            //$notImport = array('stt'=>$result[$index_import]['stt'],'name'=>$result[$index_import]['name'],'path'=>$result[$index_import]['path']);
	        }else{
	        	$log->LogError("Error | ".CJSON::encode($result), false);
	        }
	
	        if (Yii::app()->session['import_init'] == count($result)) {
	            // finish alert to update 'updated_time' for song
	            $data = $this->renderPartial('ajaxResultRow', array('imported' => $imported, 'notImport' => $notImport), true, true);
	            echo json_encode(array('finished' => 1, 'not_exist_file' => 0, 'number_import' => Yii::app()->session['imported_count'], 'is_error' => $is_error, 'success' => $success, 'count_error' => $count_error, 'data' => $data, 'imported' => $imported,'total_record'=>count($result), 'songId' => $insert_id));
	        } else {
	            $data = $this->renderPartial('ajaxResultRow', array('imported' => $imported, 'notImport' => $notImport), true, true);
	            echo json_encode(array('not_exist_file' => 0, 'number_import' => Yii::app()->session['imported_count'], 'is_error' => $is_error, 'success' => $success, 'count_error' => $count_error, 'data' => $data, 'imported' => $imported,'total_record'=>count($result),'songId' => $insert_id));
	        }
    	}catch (Exception $e)
    	{
    		$log->LogError("actionAjaxImport | Exception Error: ".$e->getMessage(), false);
    	}
        exit();
    }

    protected function removeByImporter($importer)
    {
    	$sql = "DELETE FROM import_song WHERE importer='$importer'";
    	return Yii::app()->db->createCommand($sql)->execute();
    }
    public function actionUpdateTime() {
        $result = Yii::app()->session['result'];
        $index_import = Yii::app()->session['import_init'];
        $inserted_id = Yii::app()->session['inserted_id'];
        //$inserted_id = explode(',', $inserted_id);


        $c = new CDbCriteria();
        $c->addInCondition("id", $inserted_id);

        $time = $result[$i]['updated_time'] . " " . date('H:i:s');
        $attributes = array('updated_time'=>$time);
        AdminSongModel::model()->updateAll($attributes,$c);

        /* for ($i = 0; $i < $index_import; $i++) {
            $songModel = AdminSongModel::model()->findByPk($inserted_id[count($inserted_id) - 1 - $i]);
            $songModel['updated_time'] = $result[$i]['updated_time'] . " " . date('H:i:s');
            $songModel->save();
        } */

        unset(Yii::app()->session['result']);
        unset(Yii::app()->session['inserted_id']);
        unset(Yii::app()->session['import_init']);
        echo 'ok';
        exit();
    }

}
