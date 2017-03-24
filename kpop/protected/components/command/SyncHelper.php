<?php
ini_set('memory_limit', '-1');
define("CP_ID", 1);
define("ADMIN_ID", 1);
Yii::import('application.models.admin.*');
class SyncHelper {
	private static $errorLoger;

	private static function initLoger()
	{
		if(!self::$errorLoger){
			self::$errorLoger = new KLogger("_ERROR_SYNC_CMC", KLogger::INFO);
		}
		return self::$errorLoger;
	}


	public static function syncGenre($genreList) {
		$genreNew = array();
		foreach ( $genreList as $genre ) {
			$exist = GenreModel::model ()->findByAttributes ( array ('cmc_id' => $genre ['id'] ) );
			if (empty($exist)){
				//INSERT
				$genreModel = new GenreModel();
				$genreModel->name = $genre['name'];
				$genreModel->url_key = Common::makeFriendlyUrl($genre['name']);
				$genreModel->parent_id = $genre['parent_id'];
				$genreModel->description = $genre['description'];
				$genreModel->created_by = $genre['created_by'];
				$genreModel->created_time = new CDbExpression("NOW()");
				$genreModel->updated_time = new CDbExpression("NOW()");
				$genreModel->cmc_id = $genre['id'];
				$genreModel->save();

				$genreNew[] = $genreModel;
			}
		}

		//Update parent_id theo id cua bang hien tai
		foreach($genreNew as $item){
			if($item->parent_id != 0){
				$localGenre = GenreModel::model ()->findByAttributes ( array ('cmc_id' => $item->parent_id ) );
				$item->parent_id = $localGenre->id;
				$item->save();
			}
		}
	}

	public static function syncArtist($artistList,$loger = null)
	{
		$return = array();
		foreach($artistList as $artist){
			$return[] = $artist ['id'];
			$artistModel = ArtistModel::model ()->findByAttributes ( array ('cmc_id' => $artist ['id'] ) );
			if(!empty($artistModel)){
				self::_updateArtist($artist,$artistModel);
				echo "Update artist 1 \n";
			}else{
				// Tìm ca sỹ trùng tên
				$c = new CDbCriteria();
				$c->condition = "name=:NAME AND cmc_id<>:CMCID";
				$c->params = array(":NAME"=>$artist['name'],":CMCID"=>$artist ['id']);
				$artistMap = ArtistModel::model()->findAll($c);
				
				if(empty($artistMap)){
					//Tao moi ca sy
					self::_createArtist($artist);
					echo "Create new artist 1 \n";
				}else{
					$flag = false;
					foreach ($artistMap as $artistModel){
						//Map chinh xác theo tên
						if(mb_strtolower($artistModel["name"], 'UTF-8') == mb_strtolower($artist['name'], 'UTF-8')){
							$flag = true;
							self::_updateArtist($artist,$artistModel);
							echo "Update artist 2 \n";
							break;
						}
					}
					//Neu ko map dc chinh xac ten voi ca sy nao
					if(!$flag){
						//Tao moi ca sy
						self::_createArtist($artist);
						echo "Create new artist 2 \n";
					}
				}
			}
		}
		return $return;
	}

	public static function syncSong($songList,$detailUrl,  $loger = null)
	{
		$listSong = array();
		foreach($songList as $song){
			$ret = self::_synSongItem($detailUrl, $song['id'], $loger);
			if($ret) $listSong[] = $ret;
		}
		return $listSong;
	}


	private static function _synSongItem($detailUrl,$cmcId, $loger = null)
	{
		$return = false;
		//Get Songdetail
		$contentDetail = self::_getContentCurl($detailUrl.$cmcId);
		$songDetail = json_decode($contentDetail,true);
		$songDetail = $songDetail['data'];

		$cpId = 1; //VEGA CP ID
		$songCode = time();


		// Map data
		$composerId = 0;
		$composerIds = self::_convertArtist(array($songDetail['composer']),$songDetail['composer_obj']);
		if(!empty($composerIds)){
			$composerId = $composerIds[0];
		}
		

		$artistList = self::_convertArtist($songDetail['artist_ids'],$songDetail['song_artist_obj']);
		if(empty($artistList)){
			$msg = "CMC Song {$cmcId} Khong map duoc ca sy";
			self::initLoger()->logError($msg);
			echo $msg."\n";
			return false;
		}
		$genreList = self::_convertGenre($songDetail['genre_ids']);
		if(empty($genreList)){
			$msg = "CMC Song {$cmcId} Khong map duoc genre";
			self::initLoger()->logError($msg);
			echo $msg."\n";
			return false;
		}
		// End Map data


		$transaction = Yii::app()->db->beginTransaction();
		try {
			$songModel = SongModel::model ()->findByAttributes ( array ('cmc_id' => $songDetail ['id'] ) );
			if(empty($songModel)){
				$songModel = new SongModel();
				$songModel->cmc_id =  $songDetail ['id'];
				$songModel->created_time = new CDbExpression("NOW()");
			}

			$songModel->code = $songCode;
			$songModel->name = $songDetail['name'];
			$songModel->url_key = Common::makeFriendlyUrl($songDetail['name']);
			$songModel->composer_id = (int)$composerId;
			$songModel->owner = $songDetail['owner'];
			$songModel->source = $songDetail['source'];
			$songModel->source_link = $songDetail['source_link'];
			$songModel->national = $songDetail['national'];
			$songModel->language = $songDetail['language_code'];
			$songModel->duration = $songDetail['duration'];
			$songModel->max_bitrate = $songDetail['bitrate'];
			$songModel->created_by = $songDetail['added_by'];
			$songModel->approved_by = $songDetail['approved_by'];
			$songModel->updated_by = $songDetail['updated_by'];
			$songModel->cp_id = $cpId;
			$songModel->source_path = "";
			$songModel->download_price = Yii::app()->params['price']['songDownload'];
			$songModel->listen_price = Yii::app()->params['price']['songListen'];
			$songModel->updated_time = new CDbExpression("NOW()");
			$songModel->copyright = $songDetail['copyright'];
			$ret = $songModel->save();

			if($ret){
				//Getfile
				$profileList = array();
				foreach(SongProfileModel::model()->findAll() as $profile){
					if(!isset($songDetail['url_path'][$profile->profile_id])){
						continue;
					}
					$sourcePath = $songDetail['url_path'][$profile->profile_id];
					$destPath = SongModel::model()->getAudioFilePath($songModel->id,$profile->profile_id);
					Utils::makeDir(dirname($destPath));
					$download = self::_downloadFileCurl($sourcePath, $destPath);
					//$download = true;
					if($download){
						$profileList[] = $profile->profile_id;
						$msg = "__Success download file FROM {$sourcePath} to {$destPath}";
						$loger->logInfo($msg);
					}else{
						$flagGetfile = false;
						$msg = "__Cannot download file FROM {$sourcePath} to {$destPath}";
						self::initLoger()->logError($msg);
						echo $msg."\n";
					}
				}
				// Update song_genre
				SongGenreModel::model()->updateSongCate($songModel->id,$genreList);

				$statusModel = SongStatusModel::model()->findByPk($songModel->id);
				if(!empty($profileList)){
					//Get dc file-> update lai truong profile_ids
					$songModel->profile_ids = implode(",", $profileList);
					// update convert_status=1
					$statusModel->convert_status = SongStatusModel::CONVERT_SUCCESS;
					if($songModel->isNewRecord){
						$statusModel->approve_status = SongStatusModel::WAIT_APPROVED;
					}
				}else{
					// Neu ko get dc file nao set convert fail
					$statusModel->convert_status = SongStatusModel::CONVERT_FAIL;
					self::initLoger()->LogError("CMC Song {$cmcId} khong co profile");
				}
				$songModel->code = $songModel->id;
				$songModel->save();
				$statusModel->save();
				
				//update song_artist
				SongArtistModel::model()->updateArtist($songModel->id,$artistList);
				$songModel  = SongModel::model()->findByPk($songModel->id);
				$songModel->artist_name = SongArtistModel::model()->getArtistBySong($songModel->id,"name");
				$songModel->save();
				
				//update lyric
				$songExtra = SongExtraModel::model()->findByPk($songModel->id);
				if($songExtra){
					$songExtra->lyrics = $songDetail['lyric_content'];
					$songExtra->save();
				}else{
					$songExtra = new SongExtraModel();
					$songExtra->song_id = $songModel->id;
					$songExtra->lyrics = $songDetail['lyric_content'];
					$songExtra->save();
				}
				$transaction->commit();
				$return = $cmcId;
				$loger->logInfo("Sync success ID:".$cmcId);

			}else{
				$msg = "SyncSong ID {$cmcId} FAIL: Ko luu duoc du lieu: ". var_export($songModel->getErrors());
				echo "<pre>";print_r($songDetail);echo "</pre>";exit(); 
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				$transaction->rollback();
			}

		}catch (Exception $e){
			$msg = "SyncSong ID {$cmcId} FAIL: DB Exception: ". $e->getMessage();
			self::initLoger()->LogError($msg);
			echo $msg."\n";
			$transaction->rollback();
		}
		return $return;
	}

	public static function syncVideo($videoList,$detailUrl,  $loger = null)
	{
		$return = array();
		foreach($videoList as $video){
			//Get Songdetail
			$cmcId = $video['id'];
			$contentDetail = self::_getContentCurl($detailUrl.$video['id']);
			$videoDetail = json_decode($contentDetail,true);
			$videoDetail = $videoDetail['data'];

			$cpId = 1; //VEGA CP ID
			$videoCode = time();

			// Map data
			
			$composerId = 0;
			$composerIds = self::_convertArtist(array($videoDetail['composer']),$videoDetail['composer_obj']);
			if(!empty($composerIds)){
				$composerId = $composerIds[0];
			}
			
			$artistList = self::_convertArtist($videoDetail['artist_ids'],$videoDetail['video_artist_obj']);
			if(empty($artistList)){
				$msg = "CMC Video {$cmcId} Khong map duoc ca sy";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			$genreList = self::_convertGenre($videoDetail['genre_ids']);
			if(empty($genreList)){
				$msg = "CMC Video {$cmcId} Khong map duoc genre";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End Map data

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$videoModel = VideoModel::model ()->findByAttributes ( array ('cmc_id' => $video ['id'] ) );
				if(empty($videoModel)){
					$videoModel = new VideoModel();
					$videoModel->code = $videoCode;
					$videoModel->cmc_id = $video['id'];
					$videoModel->created_time = new CDbExpression("NOW()");
				}
				
				$videoModel->name = $video['name'];
				$videoModel->url_key = Common::makeFriendlyUrl($video['name']);
				$videoModel->composer_id = (int) $composerId;
				$videoModel->genre_id = $genreList[0];
				$videoModel->owner = $video['owner'];
				$videoModel->source = $video['source'];
				$videoModel->source_link = $video['source_link'];
				$videoModel->national = "";
				$videoModel->language = $video['language_code'];
				$videoModel->duration = $video['duration'];
				$videoModel->max_bitrate = $video['bitrate'];
				$videoModel->profile_ids = "";
				$videoModel->created_by = $video['added_by'];
				$videoModel->approved_by = $video['approved_by'];
				$videoModel->updated_by = $video['updated_by'];
				$videoModel->cp_id = $cpId;
				$videoModel->source_path = "";
				$videoModel->download_price = Yii::app()->params['price']['videoDownload'];
				$videoModel->listen_price = Yii::app()->params['price']['videoListen'];
				$videoModel->updated_time = new CDbExpression("NOW()");
				$videoModel->copyright = $video['copyright'];
				$ret = $videoModel->save();
				if($ret){

					//Getfile
					$profileList = array();
					foreach(VideoProfileModel::model()->findAll() as $profile){
						if(!isset($videoDetail['url_path'][$profile->profile_id])){
							continue;
						}
						$sourcePath = $videoDetail['url_path'][$profile->profile_id];
						$destPath = VideoModel::model()->getVideoFilePath($videoModel->id,$profile->profile_id);
						Utils::makeDir(dirname($destPath));
						$download = self::_downloadFileCurl($sourcePath, $destPath);
						if($download){
							$profileList[] = $profile->profile_id;
							$msg = "__Success download file FROM {$sourcePath} to {$destPath}";
							$loger->logInfo($msg);
						}else{
							$flagGetfile = false;
							self::initLoger()->LogError("__Cannot download file FROM {$sourcePath} to {$destPath}");
						}
					}
					//get avartar
					if(isset($videoDetail['avatar_url'])){
						$avatarList = $videoDetail['avatar_url'];
						
						$sourceAvatar = $avatarList[0];
						$tmpPath = _APP_PATH_.DS."public/admin/data/tmp".DS.$videoModel->id."_sync_".time().".jpg";
						$download = self::_downloadFileCurl($sourceAvatar, $tmpPath);
						
						if($download){
							self::processAvatar($videoModel, $tmpPath, 'video');
						}else{
							$msg = "__Cannot download avatar FROM {$sourceAvatar} to {$tmpPath}";
							$loger->logInfo($msg);
						}						
					}
					
					$statusModel = VideoStatusModel::model()->findByPk($videoModel->id);

					if(!empty($profileList)){
						//Get dc file-> update lai truong profile_ids
						$videoModel->profile_ids = implode(",", $profileList);
						//update convert_status
						$statusModel->convert_status = VideoStatusModel::CONVERT_SUCCESS;
						if($videoModel->isNewRecord){
							$statusModel->approve_status = VideoStatusModel::WAIT_APPROVED;	
						}
						
					}else{
						// Neu ko get dc file nao set convert fail
						$statusModel->convert_status = VideoStatusModel::CONVERT_FAIL;
						self::initLoger()->LogError("CMC Video {$cmcId} khong co profile");
					}
					//update lyric
					$videoExtra = VideoExtraModel::model()->findByPk($videoModel->id);
					if(empty($videoExtra)){
						$videoExtra = new VideoExtraModel();
						$videoExtra->video_id = $videoModel->id;
					}
					$videoExtra->description = $videoDetail['lyric_content'];
					$videoExtra->save();
					// End update lyric
					
					$videoModel->code = $videoModel->id;
					$videoModel->save();
					$statusModel->save();
					
					//update video_artist
					VideoArtistModel::model()->updateArtist($videoModel->id,$artistList);
					$videoModel = VideoModel::model()->findByPk($videoModel->id);
					$videoModel->artist_name = VideoArtistModel::model()->getArtistByVideo($videoModel->id,"name");
					$videoModel->save();
					
					$transaction->commit();

					$loger->logInfo("Sync success VIDEO ID:".$video ['id']);
					$return[] = $video ['id'];
				}else{
					$msg = "SyncVideo id {$video['id']} FAIL: Ko luu duoc du lieu: ". var_export($videoModel->getErrors());
					self::initLoger()->LogError($msg);
					echo $msg;
					$transaction->rollback();
				}

			}catch (Exception $e){
				$msg = "SyncVideo id {$video['id']} FAIL:DB Exception: ". $e->getMessage();
				self::initLoger()->LogError($msg);
				echo $msg;
				$transaction->rollback();
			}
		}
		return $return;
	}

	public static function syncAlbum($albumList,$detailUrl,  $loger = null, $apiSongUrl)
	{
		$return = array();
		foreach($albumList as $album){
			//Get Albumdetail
			$cmcId = $album['id'];
			$contentDetail = self::_getContentCurl($detailUrl.$album['id']);
			$albumDetail = json_decode($contentDetail,true);
			$albumDetail = $albumDetail['data'];

			$cpId = CP_ID; //VEGA CP ID

			// Map data
			$artistList = self::_convertArtist($albumDetail['artist_ids'],$albumDetail['album_artist_obj']);
			if(empty($artistList)){
				$msg = "CMC Album {$cmcId} Khong map duoc ca sy";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			$genreList = self::_convertGenre(array($albumDetail['genre_id']));
			if(empty($genreList)){
				$msg = "CMC Album {$cmcId} Khong map duoc genre";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End Map data

			// Khong sync cac album rong
			if(count($albumDetail['album_song']) == 0){
				$msg = "Album {$album['id']} khong co bai hat nao";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}

			// Sync cac bai hat trong album truoc
			$listSongCmc = array();
			$songAlbumOrder = array();
			foreach($albumDetail['album_song'] as $song){
				$listSongCmc[] = $song['song_id'];
				$songAlbumOrder[$song['song_id']] = $song['sorder'];
				$songExist = SongModel::model()->findByAttributes(array("cmc_id"=>$song['song_id']));
				if(empty($songExist)){
					self::_synSongItem($apiSongUrl, $song['song_id'],$loger);
				}
			}
			$c = new CDbCriteria();
			$c->addInCondition("cmc_id", $listSongCmc);
			$c->group = "cmc_id";
			$songSynced = SongModel::model()->findAll($c);
			if(count($songSynced) < count($listSongCmc)){
				$msg = "Cac bai hat trong CMC album {$album['id']} chua dc sync ve";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End sync song

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$albumModel = AlbumModel::model ()->findByAttributes ( array ('cmc_id' => $album['id'] ) );
				if(empty($albumModel)){
					$albumModel = new AlbumModel();
					$albumModel->created_time = new CDbExpression("NOW()");
					$albumModel->cmc_id = $album['id'];
				}

				$albumModel->name = $album['name'];
				$albumModel->url_key = Common::makeFriendlyUrl($album['name']);
				$albumModel->genre_id = $genreList[0];
				$albumModel->price = Yii::app()->params['price']['albumListen'];
				$albumModel->publisher = $album['publisher'];
				$albumModel->published_date = $album['published_date'];
				$albumModel->description = $album['description'];
				$albumModel->created_by = ADMIN_ID;
				$albumModel->updated_by = ADMIN_ID;
				$albumModel->cp_id = CP_ID;
				$albumModel->updated_time = new CDbExpression("NOW()");

				$ret = $albumModel->save();
				if($ret){
					//get avatar
					$avatarSource = $albumDetail['avatar_url'];
					$tmpPath = _APP_PATH_.DS."public/admin/data/tmp".DS.$albumModel->id."_sync_album_".time().".jpg";
					$downloadAvatar = self::_downloadFileCurl($avatarSource, $tmpPath);
					if($downloadAvatar){
						self::processAvatar($albumModel, $tmpPath, 'album');
					}else{
						$msg = "__cannot download file from {$avatarSource} to {$tmpPath}"; 
						$loger->logInfo($msg);
						echo $msg."\n";
					}
					//Reset album_song
					$sql = "DELETE FROM album_song WHERE album_id=".$albumModel->id;
					Yii::app()->db->createCommand($sql)->execute();

					//Create album_song
					foreach ($songSynced as $item){
						$albumSong = new AlbumSongModel();
						$albumSong->song_id = $item['id'];
						$albumSong->album_id = $albumModel->id;
						$albumSong->status = 1;
						$albumSong->sorder = isset($songAlbumOrder[$item['cmc_id']])?$songAlbumOrder[$item['cmc_id']]:0;
						$albumSong->insert();
					}

					$albumModel->save();
					
					//update album_artist
					AlbumArtistModel::model()->updateArtist($albumModel->id,$artistList);
					$albumModel = AlbumModel::model()->findByPk($albumModel->id);
					$albumModel->artist_name = AlbumArtistModel::model()->getArtistByAlbum($albumModel->id,"name");
					$albumModel->save();
					
					$transaction->commit();

					$loger->logInfo("Sync success ALBUM ID:".$album ['id']);
					$return[] = $album ['id'];
				}else{
					$msg = "Sync FAIL ALBUM id {$album['id']} FAIL: Ko luu duoc du lieu: ". var_export($videoModel->getErrors());
					self::initLoger()->LogError($msg);
					echo $msg;
					$transaction->rollback();
				}

			}catch (Exception $e){
				$msg = "Sync FAIL ALBUM  id {$album['id']} FAIL:DB Exception: ". $e->getMessage();
				self::initLoger()->LogError($msg);
				echo $msg;
				$transaction->rollback();
			}
		}
		return $return;
	}

	static function _convertGenre($ids)
	{
		$return = array();
		foreach ($ids as $id){
			$sql = "SELECT * FROM genre_map WHERE cmc_id=:CID";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(":CID", $id);
			$mapGenre = $command->queryAll();
			foreach($mapGenre as $genre){
				$return[] = $genre["genre_id"];
			}			
		}
		array_unique($return);
		if(empty($return)){
			$return[] = 87; // Thể Loại Khác
		}
		return $return;
	}

	static function _convertArtist($ids,$songArtistObj = array())
	{
		$c = new CDbCriteria();
		$c->condition = "cmc_id <>0";
		$c->addInCondition("cmc_id", $ids);
		$ret = array();
		$artistList = ArtistModel::model()->findAll($c);
		if(empty($artistList)){
			foreach($songArtistObj as $obj){
				//$obj['name'] = preg_replace('/[^0-9\-\pL.\s\'\(\)\/]/u', ' ', $obj['name']);
				$artistObj = ArtistModel::model()->findByAttributes(array("name"=>addslashes($obj['name'])));
				if(!empty($artistObj)){
					$artistId = $artistObj->id;
					$artistObj->cmc_id =$obj['id'];
					$result = $artistObj->save(false);
					if(!$result){
						echo CHtml::errorSummary($artistObj);
					}
					$ret[] = $artistId;
				}else{
					$ret[] = self::_createArtist($obj);
				}
			}
		}else{
			foreach ($artistList as $artist){
				$ret[] = $artist->id;
			}
		}

		return $ret;
	}

	static function _createArtist($obj)
	{
		//tao moi ca sy tren he thong client
		$newArtist = new ArtistModel();
		$newArtist->name = trim($obj['name']);
		$newArtist->url_key = Common::makeFriendlyUrl($obj['name']);
		$newArtist->cmc_id = $obj['id'];
		$newArtist->created_time = date('Y-m-d H:i:s');
		$newArtist->updated_time = date('Y-m-d H:i:s');
		$newArtist->status = ArtistModel::ACTIVE;
		$newArtist->description = $obj["description"];
		$genreId = self::_convertGenre(array($obj["genre_id"]));
		$newArtist->genre_id = $genreId[0];
		$type = 0;
		if(in_array($obj["type"], array("Nghe si","Nghệ sĩ","Nghệ sỹ","Nhạc sỹ"))){
			$type = 1;
		}else{
			$type = 2;
		}
		$newArtist->artist_type_id = $type;
		if($newArtist->save()){
			//Tao avatar
			$tmpPath = 	Yii::app()->getRuntimePath()."/{$newArtist->id}_sync_img_".time().".jpg";
			$downloadAvatar = self::_downloadFileCurl($obj["avatar"], $tmpPath);
			if($downloadAvatar){
				AvatarHelper::processAvatar($newArtist, $tmpPath, 'artist');
			}
	
			self::initLoger()->LogError("Success create new artist {$obj['name']}");
			return $newArtist->id;
		}else{
			$error =  CHtml::errorSummary($newArtist);
			self::initLoger()->LogError("Can't create artist {$obj['name']}: $error","ERROR");
			return 0;
		}
	}
	
	static function _updateArtist($obj,$artistModel)
	{
		$artistModel->name = trim($obj['name']);
		$artistModel->url_key = Common::makeFriendlyUrl($obj['name']);
		$artistModel->updated_time = date('Y-m-d H:i:s');
		$artistModel->description = $obj["description"];
		$type = 0;
		if(in_array($obj["type"], array("Nghe si","Nghệ sĩ","Nghệ sỹ","Nhạc sỹ"))){
			$type = 1;
		}else{
			$type = 2;
		}
		$artistModel->artist_type_id = $type;
		$artistModel->cmc_id = $obj["id"];
		$genreId = self::_convertGenre(array($obj["genre_id"]));
		$artistModel->genre_id = $genreId[0];
		if($artistModel->save(false)){
			$avatarPath = $artistModel->getAvatarPath();
			if(!file_exists($avatarPath)){
				// Neu ca sy chua co avatar => Tao avatar
				$tmpPath = 	Yii::app()->getRuntimePath()."/{$artistModel->id}_sync_img_".time().".jpg";
				$downloadAvatar = self::_downloadFileCurl($obj["avatar"], $tmpPath);
				if($downloadAvatar){
					AvatarHelper::processAvatar($artistModel, $tmpPath, 'artist');
				}				
			}

			self::initLoger()->LogError("Success Update artist {$obj['name']}");
			return $artistModel->id;
		}else{
			$error =  CHtml::errorSummary($newArtist);
			self::initLoger()->LogError("Can't Update artist {$obj['name']}: $error","ERROR");
			return 0;
		}
	}
		
	static function _getArtistName($ids)
	{
		$c = new CDbCriteria();
		$c->addInCondition("cmc_id", $ids);
		$ret = array();
		foreach (ArtistModel::model()->findAll($c) as $artist){
			$ret[] = $artist->name;
		}
		return $ret;
	}
	public static function _getContentCurl($url)
	{
		// timeout in seconds
		$timeOut = 5;

		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_BINARYTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeOut );
		$rawdata = curl_exec ( $ch );
		if (! curl_errno ( $ch )) {
			if ($rawdata) {
				curl_close ( $ch );
				return $rawdata;
			}
		}
		curl_close ( $ch );
		return false;
	}

	public static function _postUrl($url,$data){

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 3);
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$response  = curl_exec($curl);
		if(curl_errno( $curl )) {
		}else{
		}
		curl_close($curl);
		return $response;
	}


	public static function _downloadFileCurl($url, $target) {
		$result = false;
		$rawdata = self::_getContentCurl($url);
		if($rawdata)
		{
			//save to file
			if(file_exists($target)){
				@unlink($target);
			}
			$fp = fopen($target,'w');
			fwrite($fp, $rawdata);
			fclose($fp);
			if(md5_file($url) == md5_file($target)) $result = true;
		}else{
			$result = false;
		}
		return $result;
	}
	public static function processAvatar($model, $source, $type = "artist") {

		$fileSystem = new Filesystem();

		$alowSize = Yii::app()->params['imageSize'];
		$maxSize = max($alowSize);
		$folderMax = "s0";

		foreach ($alowSize as $folder => $size) {
			// Create folder by ID
			$avatarPath = $model->getAvatarPath($model->id, $folder, true);
			//$avatarPath = str_replace('music_storage', 'vega_storage', $avatarPath);
			$fileSystem->mkdirs($avatarPath);
			@chmod($avatarPath, 0755);

			// Get link file by ID
			$savePath[$folder] = $model->getAvatarPath($model->id, $folder);
			
			if ($size == $maxSize) {
				$folderMax = $folder;
			}
		}
		// Delete file if exists
		if (file_exists($savePath[$folder])) {
			$fileSystem->remove($savePath);
		}

		if (file_exists($source)) {
			list($width, $height) = getimagesize($source);
			$imgCrop = new ImageCrop($source, 0, 0, $width, $height);

			// aspect ratio for image size
			$aspectRatioW = $aspectRatioH = 1;
			if ($type == "video") {
				$videoAspectRatio = Yii::app()->params['videoResolutionRate'];
				list($aspectRatioW, $aspectRatioH) = explode(":", $videoAspectRatio);
			}

			foreach ($savePath as $k => $v) {
				$desWidth = $alowSize[$k];
				$desHeight = round($alowSize[$k] * intval($aspectRatioH) / intval($aspectRatioW));
				if (file_exists($v) && is_file($v)) {
					@unlink($v);
				}

				if ($k == $folderMax) {
					$imgCrop->resizeRatio($v, $desWidth, $desHeight, 70);
				} else {
					$imgCrop->resizeCrop($v, $desWidth, $desHeight, 70);
				}
			}
			//if ($type != "video") {
				$fileSystem->remove($source);
			//}
		}
	}

}