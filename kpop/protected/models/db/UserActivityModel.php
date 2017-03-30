<?php
class UserActivityModel extends BaseUserActivityModel {
	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @return UserActivity the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function add($params) {
		// if(isset($params['user_id']) && $params['user_id']!=0){
		$logUser = new self ();
		$logUser->user_id = isset ( $params ['user_id'] ) ? $params ['user_id'] : '0';
		$logUser->user_phone = $params ["msisdn"];
		$logUser->activity = $params ["cmd"];
		$logUser->channel = $params ["source"];
		$logUser->obj1_id = isset ( $params ['obj1_id'] ) ? $params ['obj1_id'] : '0';
		$logUser->obj1_name = isset ( $params ['obj1_name'] ) ? $params ['obj1_name'] : '';
		$logUser->obj1_url_key = isset ( $params ['obj1_url_key'] ) ? $params ['obj1_url_key'] : '';
		$logUser->obj2_id = isset ( $params ['obj2_id'] ) ? $params ['obj2_id'] : '0';
		$logUser->obj2_name = isset ( $params ['obj2_name'] ) ? $params ['obj2_name'] : '';
		$logUser->obj2_url_key = isset ( $params ['obj2_url_key'] ) ? $params ['obj2_url_key'] : '';
		$logUser->note = isset ( $params ['note'] ) ? $params ['note'] : '';
		$logUser->loged_time = $params ['createdDatetime'];

		$logUser->save ();
		// }
	}
	protected function afterSave() {
		parent::afterSave ();
		if ($this->isNewRecord) {
			try{
				switch ($this->activity){
					case "play_song":
						$sql = "INSERT INTO song_play(song_id, user_id, loged_time) VALUES('{$this->obj1_id}', '{$this->user_id}', '{$this->loged_time}')";
						Yii::app()->db->createCommand($sql)->execute();
						$sql = "INSERT INTO song_statistic(song_id, played_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE played_count=played_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "download_song":
						$sql = "INSERT INTO song_statistic(song_id, downloaded_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE downloaded_count=downloaded_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "play_video":
						$sql = "INSERT INTO video_play(video_id, user_id, loged_time) VALUES('{$this->obj1_id}', '{$this->user_id}', '{$this->loged_time}')";
						Yii::app()->db->createCommand($sql)->execute();
						$sql = "INSERT INTO video_statistic(video_id, played_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE played_count=played_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "download_video":
						$sql = "INSERT INTO video_statistic(video_id, downloaded_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE downloaded_count=downloaded_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "play_album":
						if(!empty($this->user_phone)){
                            $user_sub = UserSubscribeModel::model()->get($this->user_phone);
                            if($user_sub){
                                $log = new KLogger('check_album_hot_list', KLogger::INFO);
                                $log->LogInfo('data:'.$this->user_phone.'||' . $this->user_id . '||'. $this->channel. '||'. $this->obj1_id. '||'. $this->obj1_name, false);
                                //log to gamification
                                try {
                                    $data = array(
                                        'msisdn' => $this->user_phone,
                                        'user_id' => $this->user_id,
                                        'source' => $this->channel,
                                        'transaction' => 'play_album',
                                        'content_id' => $this->obj1_id,
                                        'content_name'=>$this->obj1_name,
                                        'point'=> 1,
                                    );
                                    $paramsGM = array(
                                        "params" => $data
                                    );
                                    $resGM = Yii::app()->gearman->client()->doBackground('doLogGami', json_encode($paramsGM));
                                    self::model()->checkAlbumHot($this->user_id,$this->user_phone,$this->channel,$this->obj1_id);

                                }catch (Exception $e)
                                {
                                    //$e->getMessage();
                                }
                            }
						}


						$sql = "INSERT INTO album_play(album_id, user_id, loged_time) VALUES('{$this->obj1_id}', '{$this->user_id}', '{$this->loged_time}')";
						Yii::app()->db->createCommand($sql)->execute();
						$sql = "INSERT INTO album_statistic(album_id, played_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE played_count=played_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "play_playlist":
						$sql = "INSERT INTO playlist_play(playlist_id, user_id, loged_time) VALUES('{$this->obj1_id}', '{$this->user_id}', '{$this->loged_time}')";
						Yii::app()->db->createCommand($sql)->execute();
						$sql = "INSERT INTO playlist_statistic(playlist_id, played_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE played_count=played_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
					case "download_ringtone":
						$sql = "INSERT INTO ringtone_statistic(ringtone_id, downloaded_count) VALUES('{$this->obj1_id}', 1) ON DUPLICATE KEY UPDATE downloaded_count=downloaded_count+1";
						Yii::app()->db->createCommand($sql)->execute();
						break;
				}
			}
			catch (Exception $e){
				Yii::log("exception ".$e->getMessage(), "ERROR");
			}

		}
	}

	public function checkAlbumHot($user_id,$user_phone,$source,$contentId=''){
		$log = new KLogger('check_album_hot', KLogger::INFO);
		$log->LogInfo('data:'.$user_id.'||' . $user_phone . '||'. $source, false);
		$id = Yii::app()->params['ctkm']['id_collection_album_hot'];
//		$dependency = new CDbCacheDependency("SELECT MAX(created_time) FROM collection_item WHERE collect_id = $id");
//		$collection_item = CollectionItemModel::model()->cache(21600, $dependency)->findAllByAttributes(array('collect_id'=>$id));
		$collection_item = CollectionItemModel::model()->findAllByAttributes(array('collect_id'=>$id));
		$data = array();
		foreach ($collection_item as $item){
			$data[] = $item->item_id;
		}

		if(in_array($contentId, $data)){
			$log->LogInfo('content_id:'.$contentId);
			$log->LogInfo('data:'.json_encode($data));
			//log to gamification
			try {
				//lay danh sach bai hat cua album nay
				$cr = new CDbCriteria();
				$cr->alias = 't';
				$cr->condition = 't.album_id = :ALBUM_ID AND t.status = :STT';
				$cr->params = array(":ALBUM_ID"=>$contentId, ":STT"=>AlbumSongModel::ACTIVE);
				$song = AlbumSongModel::model()->with('song')->findAll($cr);
				foreach ($song as $item){
					$data = array(
						'msisdn' => $user_phone,
						'user_id' => $user_id,
						'source' => $source,
						'transaction' => 'play_song',
						'content_id' => $item->song->id,
						'content_name'=>$item->song->name,
						'point'=> 0,
					);
					$paramsGM = array(
						"params" => $data
					);
					$log->LogInfo('params:'.json_encode($paramsGM));
					$resGM = Yii::app()->gearman->client()->doBackground('doLogGami', json_encode($paramsGM));
				}

			}catch (Exception $e)
			{
				//$e->getMessage();
			}
		}
	}
}
