<?php

Yii::import('application.models.db.SongModel');
class AdminSongModel extends SongModel
{
	const ALL = -1;
	const NOT_CONVERT = 0;
	const WAIT_APPROVED = 1;
	const ACTIVE = 2;
	const CONVERT_FAIL = 3;
	const EXPIRED = 4;
	const DELETED = 5;
	const FEATURE = 10;

	public $genre_id;
	public $ccp_type=null;
	var $className = __CLASS__;
	public $lyric = NULL;
	public $object_type = null;


	protected function beforeSave() {
		if(!$this->url_key) $this->url_key = Common::url_friendly($this->name);
		if(!$this->updated_time) $this->updated_time = date("Y-m-d H:i:s");
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		//if($this->status == self::NOT_CONVERT && isset($this->source_path) && $this->source_path != ""){
		/*
		$status = AdminSongStatusModel::model()->findByPk($this->id);
		if($status->convert_status == SongStatusModel::NOT_CONVERT){
			$songlist[] = $this->id;
			AdminConvertSongModel::model()->updateStatus($songlist,AdminConvertSongModel::NOT_CONVERT);
		}
		*/
		return parent::afterSave();
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'user'=>array(self::BELONGS_TO, 'AdminAdminUserModel', 'created_by', 'select'=>'id, username', 'joinType'=>'LEFT JOIN'),
            'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
            'songstatus'=>array(self::HAS_ONE, 'AdminSongStatusModel', 'song_id', 'joinType'=>'LEFT JOIN'),
            'songdeleted'=>array(self::HAS_ONE, 'AdminSongDeletedModel', 'song_id', 'joinType'=>'LEFT JOIN'),
            'songextra' => array(self::HAS_ONE, 'AdminSongExtraModel', 'song_id', 'joinType'=>'LEFT JOIN'),
            'songstatistic'=>array(self::HAS_ONE, 'AdminSongStatisticModel', 'song_id', 'joinType'=>'LEFT JOIN'),
        	'songgenre'=>array(self::HAS_ONE, 'AdminSongGenreModel', 'song_id', 'joinType'=>'LEFT JOIN'),
        	'composer'=>array(self::BELONGS_TO, 'AdminArtistModel', 'composer_id', 'joinType'=>'LEFT JOIN'),
        ));
    }

	/*
	 * Update song mass
	 * @params: array $data
	 * @params: string $cids // List Song ID
	 * */
	public function massupdate($data,$listSong=array()){

		//UPDATE SONG
		$c = new CDbCriteria();
		$c->addInCondition("id", $listSong);
		$attributes = array();

        /// List suggest: nhac mien tay..... (id: suggest_1, ....)
        $suggestLists = MainContentModel::getSuggestList();
        foreach($suggestLists as $key => $val){
            if(!empty($data[$key])){
                $attributes[$key]= $data[$key];
            }
        }

		if(isset($data['genre_id']) && $data['genre_id'] != ""){
			//$attributes['genre_id']= $data['genre_id'];
			AdminSongGenreModel::model()->massUpdateSong($listSong,$data['genre_id']);
		}
		if(isset($data['artist_id']) && $data['artist_id'] != ""){
			$attributes['artist_id']= $data['artist_id'];
			$attributes['artist_name']=  AdminArtistModel::model()->findByPk($data['artist_id'])->name;
		}
		if(!empty($attributes)){
			$attributes['updated_time'] = date("Y-m-d H:i:s");
			self::model()->updateAll($attributes,$c);
		}
	}

	/*
	 * Set delete Song
	 * */
	public function setdelete($adminId, $reason = "", $songList = array(), $status= 0)
	{
		//UPDATE SONG_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		if($status==3) {
			$attributes['approve_status'] = AdminSongStatusModel::DELETED;
		}else{
			$attributes['approve_status'] = AdminSongStatusModel::REJECT;
		}
		AdminSongStatusModel::model()->updateAll($attributes,$c);

		// Insert to song_delete
		$songDeleteList = AdminSongDeletedModel::model()->findAll();
		$songDeleteList = CHtml::listData($songDeleteList, "song_id", "song_id");
		for($i=0; $i<count($songList); $i++){
			if(!in_array($songList[$i], $songDeleteList)){
				 $songDel = new AdminSongDeletedModel();
				 $songDel->song_id = $songList[$i];
				 $songDel->deleted_reason = $reason;
				 $songDel->deleted_by = $adminId;
				 $songDel->deleted_time = date("Y-m-d H:i:s");
				 $songDel->save();
			}
		}
	}

	public function restore($songList,$adminId)
	{
		// REMOVE SONG IN SONG_DELETE
		$conditionDelete = "song_id in (".implode(",", $songList).")";
		AdminSongDeletedModel::model()->deleteAll($conditionDelete);

		//UPDATE STATUS IN SONG_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		$attributes['approve_status'] = AdminSongStatusModel::WAIT_APPROVED;
		AdminSongStatusModel::model()->updateAll($attributes,$c);

	}

	public function getListByStatus($status,$cpId=0)
	{
		$criteria=new CDbCriteria;
		$criteria->join = "INNER JOIN song_status st ON t.id = st.song_id";

		switch ($status){
			case self::NOT_CONVERT:
				$criteria->condition = "st.convert_status = ".AdminSongStatusModel::NOT_CONVERT;
				break;
			case self::CONVERT_FAIL:
				$criteria->condition = "st.convert_status = ".AdminSongStatusModel::CONVERT_FAIL;
				break;
			case self::WAIT_APPROVED:
				$criteria->condition = "st.approve_status = ".AdminSongStatusModel::WAIT_APPROVED;
				break;
			case self::ACTIVE:
				$criteria->condition = "st.approve_status = ".AdminSongStatusModel::APPROVED
									." AND st.convert_status = ".AdminSongStatusModel::CONVERT_SUCCESS
									." AND st.artist_status = ".AdminSongStatusModel::ARTIST_PUBLISH ;
				break;
			case self::DELETED:
				$criteria->condition = "st.approve_status = ".AdminSongStatusModel::REJECT;
				break;
			case self::ALL:
			default:
				$criteria->condition = "st.approve_status <> ".AdminSongStatusModel::REJECT;
				break;
		}
		if(isset($cpId) && $cpId != 0){
			$criteria->addCondition("t.cp_id='{$cpId}'");
		}
		$criteria->order = "t.id DESC";
		return self::model()->findAll($criteria);
	}

	public function setApproved($songList=array(),$adminId=null)
	{
		//UPDATE TO SONG_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		$attributes['approve_status'] = AdminSongStatusModel::APPROVED;
		AdminSongStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO SONG
		$c = new CDbCriteria();
		$c->addInCondition("id", $songList);
		$attributes = array('approved_by'=>$adminId,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminSongModel::model()->updateAll($attributes,$c);
	}

	public function setWaitApproved($songList=array(),$adminId=null)
	{
		//UPDATE TO SONG_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		$attributes['approve_status'] = AdminSongStatusModel::WAIT_APPROVED;
		AdminSongStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO SONG
		$c = new CDbCriteria();
		$c->addInCondition("id", $songList);
		$attributes = array('approved_by'=>0,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminSongModel::model()->updateAll($attributes,$c);
	}

	public function setReconvert($songList=array())
	{
		//UPDATE TO SONG_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		$attributes['convert_status'] = AdminSongStatusModel::NOT_CONVERT;
		//$attributes['approve_status'] = AdminSongStatusModel::WAIT_APPROVED;
		$attributes['ivr_convert_status'] = 0;
		AdminSongStatusModel::model()->updateAll($attributes,$c);

		//UPDATE CONVERT_SONG
		$c = new CDbCriteria();
		$c->addInCondition("song_id", $songList);
		$attributes['status'] = AdminSongStatusModel::NOT_CONVERT;
		$rowUpdate = AdminConvertSongModel::model()->updateAll($attributes,$c);
		if($rowUpdate == 0){
			AdminConvertSongModel::model()->updateStatus($songList,AdminConvertSongModel::NOT_CONVERT);
		}

		//UPDATE TO SONG
		$c = new CDbCriteria();
		$c->addInCondition("id", $songList);
		$attributes = array('approved_by'=>0,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminSongModel::model()->updateAll($attributes,$c);
	}
	/*
	 * NOT USE IN NEW VERSION DB
	public function updateStatus($id,$adminId,$status)
	{
		$song = self::model()->findByPk($id);
		if($song->url_key == ""){
			$song->url_key = Common::url_friendly($song->name);
		}
		$song->approved_by = $adminId;
		$song->updated_by = $adminId;
		$song->updated_time = date("Y-m-d H:i:s");
		$song->status = $status;
		$res = $song->save();
		return $song;
	}
	*/

	public function setReSync($songList=array())
	{
		$condition = implode(",", $songList);
		$sql = "UPDATE sync_song SET sync_status=0,sync_times=0 WHERE song_id IN ($condition)";
		Yii::app()->db->createCommand($sql)->execute();
	}

	public function checkpermision($songId,$cpId)
	{
		if($cpId == 0) return true;
		$song = self::model()->findByPk($songId);
		if(isset($song) && $song->cp_id == $cpId){
			return true;
		}
		return false;
	}

	public function search($lyric_filter = false,$genre_id = null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.code',$this->code);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.url_key',$this->url_key,true);

		$criteria->compare('t.artist_name',$this->artist_name,true);
		$criteria->compare('t.composer_id',$this->composer_id);
		$criteria->compare('t.duration',$this->duration);
		$criteria->compare('t.max_bitrate',$this->max_bitrate);
		$criteria->compare('t.copyright',$this->copyright);
		$criteria->compare('t.created_by',$this->created_by);
            
		$criteria->compare('t.cp_id',$this->cp_id);
        $criteria->compare('t.sync_status',$this->sync_status);
		//$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('t.updated_time',$this->updated_time,true);
		$criteria->compare('t.sorder',$this->sorder);

		
		if(!empty($this->created_time)){
			$criteria->addBetweenCondition('t.created_time',$this->created_time[0],$this->created_time[1]);
		}
		
		if($this->ccp_type==='0'){
			//TQ
			$criteria->join = "INNER JOIN song_copyright sc ON t.id = sc.song_id";
			$criteria->addCondition("sc.type=0");
			$criteria->addCondition("sc.active=1");
		}elseif($this->ccp_type==='1'){
			//QLQ
			$criteria->join = "INNER JOIN song_copyright sc ON t.id = sc.song_id";
			$criteria->addCondition("sc.type=1");
			$criteria->addCondition("sc.active=1");
		}
		
		
		if(empty($genre_id)){
			$genre_id = $this->genre_id;
		}
		$genreCondition = "true";
		if(!empty($genre_id)){
        	//$criteria->join .= " INNER JOIN song_genre sc ON t.id=sc.song_id ";

            $genreModel = GenreModel::model()->findByPk($genre_id);
            // the loai cha
            if($genreModel->parent_id == 0){
                $crite = new CDbCriteria;
                $crite->condition = "id = $genre_id OR parent_id = $genre_id AND status = ". SongModel::ACTIVE;
                $childGenres = GenreModel::model()->findAll($crite);
                $genre_ids = array();
                foreach($childGenres as $childGenre)
                    $genre_ids[] = $childGenre->id;
                if(count($genre_ids)){
                    $genre_ids = implode(',',$genre_ids);
                    //$criteria->addCondition("sc.genre_id IN ($genre_ids)");
                    $genreCondition = "sc.genre_id IN ($genre_ids)";
                }else{
                    //$criteria->addCondition("sc.genre_id={$genre_id}");
                	$genreCondition = "sc.genre_id={$genre_id}";
                }
            }else{
                //$criteria->addCondition("sc.genre_id={$genre_id}");
            	$genreCondition = "sc.genre_id={$genre_id}";
            }

        }
        $joinWith['songgenre'] = array(        		
        		'joinType'=>'INNER JOIN',
        		'alias'=>'sc',
        		'condition'=> $genreCondition
        );
        
        
        $joinWith[] = 'songextra';
        $joinWith[]='songstatistic';
		if($lyric_filter && $this->lyric != 2){
			if($this->lyric)
				$ct = "songextra.lyrics <> ''";
			else
				$ct = "songextra.lyrics is null or songextra.lyrics = ''";
			$criteria->addCondition($ct);
		}

            switch ($this->status){
                case self::NOT_CONVERT:
                    if(!isset($this->status)){
                        $condition = "st.approve_status <> ".AdminSongStatusModel::REJECT;
                        break;
                    }
                    $condition = "st.convert_status = ".AdminSongStatusModel::NOT_CONVERT;
                    $condition .= " AND st.approve_status <> ".AdminSongStatusModel::REJECT;
                    break;
                case self::CONVERT_FAIL:
                    $condition = "st.convert_status = ".AdminSongStatusModel::CONVERT_FAIL;
                    $condition .= " AND st.approve_status <> ".AdminSongStatusModel::REJECT;
                    break;
                case self::WAIT_APPROVED:
                    $condition = "st.approve_status = ".AdminSongStatusModel::WAIT_APPROVED
                                ." AND st.convert_status = ".AdminSongStatusModel::CONVERT_SUCCESS;
                    break;
                case self::ACTIVE:
                     $condition = "st.approve_status = ".AdminSongStatusModel::APPROVED
                                        ." AND st.convert_status = ".AdminSongStatusModel::CONVERT_SUCCESS;                                        
                	//$condition = "t.status=".SongModel::ACTIVE;
                    break;
                case self::DELETED:
                    $joinWith[] = 'songdeleted';
                    $condition = "st.approve_status = ".AdminSongStatusModel::REJECT
						." OR st.approve_status = ".AdminSongStatusModel::DELETED ;
                    //$condition = "t.status=".SongModel::DEACTIVE;
                    break;
                case self::ALL:
                default:
                    $condition = "st.approve_status <> ".AdminSongStatusModel::REJECT;
                    break;
            }            
            //$criteria->addCondition($condition);
            
            $joinWith['songstatus'] = array(
            		'select'=>false,
            		'joinType'=>'INNER JOIN',
            		'alias'=>'st',
            		'condition'=> $condition
            );
            
		$criteria->with = $joinWith;
		$criteria->select = "`t`.`id` , `t`.`code` , `t`.`name` , `t`.`artist_name` , `t`.`created_by` , `t`.`updated_by` , `t`.`cp_id` , `t`.`download_price` , `t`.`listen_price` , `t`.`created_time`, `t`.`status`, `t`.`profile_ids`,`t`.`cmc_id`";
		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.created_time DESC, t.updated_time DESC'),
            'pagination'=>array(
				            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
						),
		));
	}

    public function simpleSearch($genreId = null)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.status',$this->status,true);
		$criteria->compare('t.artist_name',$this->artist_name,true);
		$criteria->compare('t.max_bitrate',$this->max_bitrate);
		$criteria->compare('t.cp_id',$this->cp_id);
        if(!empty($this->genre_id) && empty($this->genre_id_2)){
            $genreId = $this->genre_id;
        }
        $criteriaJoin = "";
        if($genreId){
            //$conditi = " t.genre_id = $genreId OR t.genre_id_2 = $genreId";
            //$criteria->addCondition($conditi);
            $criteriaJoin = "INNER JOIN song_genre sc ON t.id = sc.song_id ";
            $condition = " sc.genre_id = $genreId";
            $criteria->addCondition($condition);
        }
		$criteria->join = $criteriaJoin." INNER JOIN song_status st ON t.id = st.song_id";
        $condition = "st.artist_status = ".AdminSongStatusModel::ARTIST_PUBLISH ;
        $criteria->addCondition($condition);
		if($this->object_type=='mgChannel'){
			$criteria->addCondition("st.ivr_convert_status=1");
		}
		
		if($this->lyric != 2 && $this->lyric!=NULL){
			$joinWith[] = 'songextra';
			if($this->lyric)
				$ct = "songextra.lyrics <> ''";
			else
				$ct = "songextra.lyrics is null or songextra.lyrics = ''";
			$criteria->addCondition($ct);
			$criteria->with = $joinWith;
		}
		
		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.created_time DESC, t.updated_time DESC'),
            'pagination'=>array(
				            'pageSize'=> Yii::app()->params['pageSize'],
						),
		));
	}

    public static function updateSongGroupId($songModel,$artistList)
    {
    	$artistStr = implode(",", $artistList);
        $criteria = new CDbCriteria;
        $criteria->join = "LEFT JOIN song_artist t2 ON t.id = t2.song_id";
        $criteria->condition = "id<:ID and status=:STATUS AND name=:NAME AND t2.artist_id IN ($artistStr)";
        $criteria->params = array(":ID"=>$songModel->id, ":STATUS"=>SongModel::ACTIVE, ":NAME"=>$songModel->name);
        $baseSong = SongModel::model()->find($criteria);
        if ($baseSong)
        {
            $songModel->base_id = $baseSong->base_id;
        }
        else
        {
            $songModel->base_id = $songModel->id;
        }
        $songModel->save();
    }
}