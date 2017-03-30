<?php

class AdminImportSongModel extends SongModel {

    const ACTIVE = 1;
    const DEACTIVE = 0;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function saveLogFile($content, $append = true) {
        $operate = 'w';
        if ($append)
            $operate = 'a';
        $filename = _APP_PATH_ . DS . "log_import.txt";
        $date = date('d/m/Y h:i:s', time());
        $fp = fopen($filename, $operate);
        fwrite($fp, $date . ': ' . $content . "\n");
        fclose($fp);
    }

    public function ListFiles($dir) {
        if ($dh = opendir($dir)) {
            $files = Array();
            $inner_files = Array();
            while ($file = readdir($dh)) {
                if ($file != "." && $file != ".." && $file[0] != '.') {
                    if (is_dir($dir . "/" . $file)) {
                        $inner_files = $this->ListFiles($dir . "/" . $file);
                        if (is_array($inner_files))
                            $files = array_merge($files, $inner_files);
                    } else {
                        array_push($files, $dir . "/" . $file);
                    }
                }
            }
            closedir($dh);
            return $files;
        }
    }

    public function importSong($songInfo, $audioPath = "") {
        //return $audioPath.DS.$songInfo['path'].DS.$songInfo['file'];
        if (file_exists($fileMp3 = $audioPath . DS . $songInfo['path'] . DS . $songInfo['file'])) {
            $model = new AdminSongModel;
            $songMeta = new AdminSongMetadataModel;
            $path_info = $this->ExportPathSong($songInfo['path']);

            $cat_list = $this->GetCategoryDbInfo(true);
            $arts_list = $this->GetArtistDbInfo(true);

            $category = $this->CompareCategory($songInfo['category'], $cat_list);
            
            $composer = $this->CompareCategory($songInfo['composer'], $arts_list, true);
            if (!$category) {
//				$attributesGenre = array("name" => $songInfo['category'], "parent_id" =>0,'description' =>'','status' => self::ACTIVE);
//				if($id = $this->saveGenre($attributesGenre))
//				$genre_id = $id;
//				$attributesGenre = array("name" => $songInfo['sub_category'], "parent_id" =>$genre_id,'description' =>'','status' =>self::ACTIVE);
//				if($id = $this->saveGenre($attributesGenre))
//				$genre_id = $id;
                $genre_id = 1111; // category "Unknow"
            } else {
                $genre_id = $category['id'];
                if ($category['parent_id'] > 0) {
                    $genre_id = $category['parent_id'];
                } else {
                    $sub_category = $this->CompareCategory($songInfo['sub_category'], $cat_list);
//					if(!$sub_category)
//					{
//						$attributesGenre = array("name" => $songInfo['sub_category'], "parent_id" =>$genre_id,'description' =>'','status' => self::ACTIVE);
//					}
//					if($id = $this->saveGenre($attributesGenre))
//					$genre_id = $id;
                    if (!$sub_category) {
                        $genre_id = 1111;
                    }
                    else
                        $genre_id = $sub_category['id'];
                }
            }
            if (!$composer) {
                $attributesArtist = array("name" => $songInfo['composer'], "url_key" => Common::makeFriendlyUrl($songInfo['composer']), 'genre_id' => $genre_id, 'description' => '', 'status' => self::ACTIVE);
                //$this->dumpPre($attributesArtist);
                if ($id = $this->saveArtist($attributesArtist)) {
                    $composer_id = $id;
                }
                //$composer_id=157298;
            } else {
                $composer_id = $composer['id'];
            }
			
            //multi artist
            if(strpos($songInfo['artist'], ',')!==false){
            	$artistArray = explode(',', $songInfo['artist']);
            }else{
            	$artistArray = array($songInfo['artist']);
            }
            $artistIdArr = array();
            foreach ($artistArray as $artistItem){
            	$artist = $this->CompareCategory($artistItem, $arts_list, true);
            	if (!$artist) {
            		//create new Artist if not exists
            		$attributesArtist = array("name" => $artistItem, "url_key" => Common::makeFriendlyUrl($artistItem), 'genre_id' => $genre_id, 'description' => '', 'status' => self::ACTIVE);
            		//$this->dumpPre($attributesArtist);
            		if ($id = $this->saveArtist($attributesArtist)) {
            			//$artist_id = $id;
            			$artistIdArr[] = $id;
            		}
            		//$artist_id=157298;
            	} else {
            		//$artist_id = $artist['id'];
            		$artistIdArr[] = $artist['id'];
            	}
            }
            if(!isset($artistIdArr[0])){
            	$artistIdArr[0] = 0;
            }

            $attributesSong = array('autoconfirm' => $songInfo['autoconfirm'],
                "updated_time" => $songInfo['updated_time'],
                "created_time" => $songInfo['created_time'],
                "source_path" => '', "name" => $songInfo['name'], 'url_key' => Common::makeFriendlyUrl($songInfo['name']), "genre_id" => $genre_id, 'artist_name' => $songInfo['artist'], "artist_id" => $artistIdArr[0], 'composer_name' => $songInfo['composer'], 'composer_id' => $composer_id, 'cp_id' => 1);
            $songId = $this->saveSong($attributesSong, $fileMp3);
            if ($songInfo['autoconfirm'] == 1) {
                $model_status = AdminSongStatusModel::model()->findByPk($songId);
                if ($model_status !== null) {
                    $model_status['approve_status'] = 1;
                    $updateStatus = $model_status->save();
                }
//                            $selfModel = new AdminSongModel;
//                            $selfModel['updated_time'] = $songInfo['updated_time'];
//                            $updateTime = $selfModel->save();
            }
            //save genre to songCate table
            $genreArr = array($genre_id);
            AdminSongGenreModel::model()->updateSongCate($songId, $genreArr);

            //Update groupID
            $model = AdminSongModel::model()->findByPk($songId);
            //AdminSongModel::model()->updateSongGroupId($model, array($artist_id));
            AdminSongModel::model()->updateSongGroupId($model, $artistIdArr);

            // Save song_artist
            AdminSongArtistModel::model()->updateArtist($model->id, $artistIdArr);
            $model->artist_name = AdminSongArtistModel::model()->getArtistBySong($model->id, 'name');
            $model->save();

            return $songId;
        } else {
        	$log = new KLogger('LOG_IMPORT_FILE_SONG_PNV_ERR2', KLogger::INFO);
        	$log->LogInfo("NOT FILE IN | ".$audioPath . DS . $songInfo['path'] . DS . $songInfo['file'],false);
            return false;
        }
    }

    public function saveGenre($attributes) {

        $model = new AdminGenreModel;
        $model->attributes = $attributes;
        $model->setAttributes(
                array(
                    'created_by' => 1,
                    'created_time' => date("Y-m-d H:i:s"),
                    'updated_time' => date("Y-m-d H:i:s")
                )
        );
        if ($model->save()) {
            $id = $model->id;
            return $id;
        }
        else
            return false;
    }

    public function saveArtist($attributes) {

        $model = new AdminArtistModel();
        $model->attributes = $attributes;
        $model->setAttributes(
                array(
                    'created_by' => 1,
                    'created_time' => date("Y-m-d H:i:s"),
                    'updated_time' => date("Y-m-d H:i:s")
                )
        );
        if ($model->save()) {
            $id = $model->id;
            return $id;
        }
        else
            return false;
    }

    public function saveSong($attributes, $fileMp3) {

        if (trim($fileMp3) == "") {
            return 4; //file mp3 trong
        }
        $model = new AdminSongModel();
        $model->attributes = $attributes;
        ///$model->setAttribute('created_by', Yii::app()->user->id);
        $cpId = 1;
        $songCode = AdminAdminUserModel::model()->getMaxContentCode($cpId, 'song');
        if ($songCode) {
            if ($attributes['autoconfirm'] == 1)
                $data = array(
                    'code' => $songCode,
                    'created_time' => $attributes['created_time'] . " " . date("H:i:s"),
                    'updated_time' => $attributes['updated_time'] . " " . date("H:i:s"),
                    'created_by' => 441,
                );
            else
                $data = array(
                    'code' => $songCode,
                    'created_time' => date("Y-m-d H:i:s"),
                    'updated_time' => date("Y-m-d H:i:s"),
                    'created_by' => 1,
                );

            $model->setAttributes($data);
            if ($model->save()) {
                if (!$source_path = $this->moveFile($model, $fileMp3))
                    return false;
                //Create Convert Song
                $songlist[] = $model->id;
                AdminConvertSongModel::model()->updateStatus($songlist, AdminConvertSongModel::NOT_CONVERT);
                $dataExtra['source_path'] = $source_path;
                $dataExtra['source_path'] = $source_path;
                $model->setAttributes($dataExtra);
                $model->save();
                return $model->id;
            }
            else{
                print_r($model->getErrors());
                return 2; //Không save duoc
            }
        }
        else {
            return 3; //het quen up bai
        }
    }

    public function CompareArray($op1, $op2) {

        if (count($op1) < count($op2)) {
            return -1;
        } elseif (count($op1) > count($op2)) {
            return 1;
        }
        foreach ($op1 as $key => $val) {
            if (!array_key_exists($key, $op2)) {
                return null;
            } elseif ($val < $op2[$key]) {
                return -1;
            } elseif ($val > $op2[$key]) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * 
     * @param array $cat
     * @param unknown $array
     * @param string $artist
     * @return array
     */
    public function CompareCategoryMultiId($cat, $array = array(), $artist = false) {
    	$ids = array();
    	foreach ($cat as $value){
	    	foreach ($array as $key => $arr) {
	    		if (array_search(strtolower(Common::strNormal($value)), $arr)) {
	    		   $ids[] = $arr['id'];
	    		}
	    	}
    	}
    	return $ids;
    }
    
    public function CompareCategory($cat, $array = array(), $artist = false) {
        foreach ($array as $key => $arr) {
            if (array_search(strtolower(Common::strNormal($cat)), $arr)) {
                if (!$artist) {
                    $ids = array('id' => $arr['id'], 'parent_id' => $arr['parent_id']);
                }
                else
                    $ids = array('id' => $arr['id']);
                break;
            }
        }
        return $ids;
    }

    /**
     * Get all Category
     * @return $id,$name (in array)
     */
    public function GetCategoryDbInfo($nosig = false) {

        $cat_result = AdminGenreModel::Model()->findAll();
        $cats = array();
        foreach ($cat_result as $val) {
            if ($nosig) {
                $cats[] = array('id' => $val->id, 'name' => strtolower(Common::strNormal($val->name)), 'parent_id' => $val->parent_id);
            }
            else
                $cats[] = array('id' => $val->id, 'name' => $val->name, 'parent_id' => $val->parent_id);
        }
        return $cats;
    }

    public function GetArtistDbInfo($nosig = false) {

        $artist_list = AdminArtistModel::Model()->findAll();
        $arts = array();
        foreach ($artist_list as $val) {
            if ($nosig) {
                $arts[] = array('id' => $val->id, 'name' => strtolower(Common::strNormal($val->name)));
            }
            else
                $arts[] = array('id' => $val->id, 'name' => $val->name);
        }
        return $arts;
    }

    public function GetSongDbInfo($nosig = false) {

        $song_list = AdminSongModel::Model()->findAll();
        $songs = array();
        foreach ($song_list as $val) {
            if ($nosig) {
                $songs[] = array('id' => $val->id, 'name' => strtolower(Common::strNormal($val->name)));
            }
            else
                $songs[] = array('id' => $val->id, 'name' => $val->name);
        }
        return $songs;
    }

    public function ExportPathSong($path = "") {

        if (empty($path))
            return false;
        $path = str_replace('\\', DS, $path);
        if (substr($path, -1) != DS)
            $path = $path . DS;
        $song_comp = explode(DS, $path);
        $count = count($song_comp);
        if ($count < 4)
            return false;
        $result['album'] = $song_comp[$count - 2];
        $result['artist'] = $song_comp[$count - 3];
        $result['sub_category'] = $song_comp[$count - 4];
        $result['category'] = $song_comp[$count - 5];

        return $result;
    }

    protected function moveFile($model, $filePath) {
        if (empty($filePath)) {
            return false;
        }
        $saveFilePath = $model->getSongOriginPath($model->id);
        $saveDbPath = $model->getSongOriginPath($model->id, false);
        $fileSystem = new Filesystem();
        $fileSystem->copy($filePath, $saveFilePath);
        $model->source_path = $saveDbPath;
        $model->save();
        return $saveDbPath;
    }

    public function isUtf8($string) {
        if (function_exists("mb_check_encoding") && is_callable("mb_check_encoding")) {
            return mb_check_encoding($string, 'UTF8');
        }
        return preg_match('%^(?:
			  [\x09\x0A\x0D\x20-\x7E]            # ASCII
			| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
			|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
			|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
			|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		)*$%xs', $string);
    }

    public function my_encoding($string) {
        if (!$this->isUtf8($string)) {
            $string = utf8_encode($string);
        }
        return $string;
    }

}