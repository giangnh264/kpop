<?php

Yii::import('application.models.db.VideoModel');

class AdminVideoModel extends VideoModel
{
	const ALL = -1;
	const NOT_CONVERT = 0;
	const WAIT_APPROVED = 1;
	const ACTIVE = 2;
	const CONVERT_FAIL = 3;
	const EXPIRED = 4;
	const DELETED = 5;
	const FEATURE = 10;

    var $className = __CLASS__;
    public $lyric = NULL;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	protected function beforeSave()
	{
		if(!$this->url_key) $this->url_key = Common::url_friendly($this->name);
		if(!$this->updated_time) $this->updated_time = date("Y-m-d H:i:s");
		return parent::beforeSave();
	}

    protected function afterSave()
    {
    	$status = AdminVideoStatusModel::model()->findByPk($this->id);
		if($status->convert_status == VideoStatusModel::NOT_CONVERT && $this->source_path){
			$videoList[] = $this->id;
			AdminConvertVideoModel::model()->updateStatus($videoList,AdminConvertVideoModel::NOT_CONVERT);
		}
    }

    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'genre'=>array(self::BELONGS_TO, 'AdminGenreModel', 'genre_id', 'select'=>'id, name'),
        	'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name','alias' => 'cp'),
        	'user'=>array(self::BELONGS_TO, 'AdminAdminUserModel', 'created_by', 'select'=>'id, username','alias' => 'u', 'joinType'=>'LEFT JOIN' ),
        	'videostatus'=>array(self::HAS_ONE, 'AdminVideoStatusModel', 'video_id', 'joinType'=>'LEFT JOIN'),
             'videoextra' => array(self::HAS_ONE, 'AdminVideoExtraModel', 'video_id', 'joinType'=>'LEFT JOIN'),
        ));
    }

    public function setDelete($adminId, $reason = "", $listVideo = array(), $status = 0)
    {
    	//UPDATE VIDEO_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $listVideo);
		if($status==3) {
			$attributes['approve_status'] = AdminVideoStatusModel::DELETED;
		}else{
			$attributes['approve_status'] = AdminVideoStatusModel::REJECT;
		}

		AdminVideoStatusModel::model()->updateAll($attributes,$c);

		// INSERT TO VIDEO_DELETE
		$videoDeleteList = AdminVideoDeletedModel::model()->findAll();
		$videoDeleteList = CHtml::listData($videoDeleteList, "video_id", "video_id");
		for($i=0; $i<count($listVideo); $i++){
			if(!in_array($listVideo[$i], $videoDeleteList)){
				 $videoDel = new AdminVideoDeletedModel();
				 $videoDel->video_id = $listVideo[$i];
				 $videoDel->deleted_by = $adminId;
				 $videoDel->deleted_reason = $reason;
				 $videoDel->deleted_time = date("Y-m-d H:i:s");
				 $videoDel->save();
			}
		}
    }

	/*
	 * Update video mass
	 * @params: array $data
	 * @params: int $listVideo // List Song ID. Empty when update All
	 * */
	public function massUpdate($data, $listVideo=array()){

		//UPDATE VIDEO
		$c = new CDbCriteria();
		$c->addInCondition("id", $listVideo);
		$attributes = array();

        /// List suggest: nhac mien tay..... (id: suggest_1, ....)
        $suggestLists = MainContentModel::getSuggestList();
        foreach($suggestLists as $key => $val){
            if(!empty($data[$key])){
                $attributes[$key]= $data[$key];
            }
        }

		if(isset($data['genre_id']) && $data['genre_id'] != ""){
			$attributes['genre_id']= $data['genre_id'];
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

	public function restore($videoList,$adminId)
	{
		// REMOVE SONG IN VIDEO_DELETE
		$conditionDelete = "video_id in (".implode(",", $videoList).")";
		AdminVideoDeletedModel::model()->deleteAll($conditionDelete);

		//UPDATE STATUS IN VIDEO_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $videoList);
		$attributes['approve_status'] = AdminVideoStatusModel::WAIT_APPROVED;
		AdminVideoStatusModel::model()->updateAll($attributes,$c);

	}


	public function getListByStatus($status,$cpId=0)
	{
		$criteria=new CDbCriteria;
		$criteria->join = "INNER JOIN video_status vt ON t.id = vt.video_id";

		switch ($status){
			case self::NOT_CONVERT:
				$condition = "vt.convert_status = ".AdminVideoStatusModel::NOT_CONVERT;
				$condition .= " AND vt.approve_status <> ".AdminVideoStatusModel::REJECT;
				break;
			case self::CONVERT_FAIL:
				$condition = "vt.convert_status = ".AdminVideoStatusModel::CONVERT_FAIL;
				$condition .= " AND vt.approve_status <> ".AdminVideoStatusModel::REJECT;

				break;
			case self::WAIT_APPROVED:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::WAIT_APPROVED;
				$condition .= " AND vt.convert_status = ".AdminVideoStatusModel::CONVERT_SUCCESS;
				break;
			case self::ACTIVE:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::APPROVED
									." AND vt.convert_status = ".AdminVideoStatusModel::CONVERT_SUCCESS
									." AND vt.artist_status = ".AdminVideoStatusModel::ARTIST_PUBLISH ;
				break;
			case self::DELETED:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::REJECT;
				break;
			case self::ALL:
			default:
				$condition = "vt.approve_status <> ".AdminVideoStatusModel::REJECT;
				break;
		}
		$criteria->addCondition($condition);

		if(isset($cpId) && $cpId != 0){
			$criteria->addCondition("t.cp_id='{$cpId}'");
		}
		$criteria->order = "t.id DESC";
		return self::model()->findAll($criteria);
	}

	public function setApproved($videoList=array(),$adminId=null)
	{
		//UPDATE TO VIDEO_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $videoList);
		$attributes['approve_status'] = AdminVideoStatusModel::APPROVED;
		AdminVideoStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO VIDEO
		$c = new CDbCriteria();
		$c->addInCondition("id", $videoList);
		$attributes = array('approved_by'=>$adminId,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminVideoModel::model()->updateAll($attributes,$c);
	}

	public function setWaitApproved($videoList=array(),$adminId=null)
	{
		//UPDATE TO VIDEO_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $videoList);
		$attributes['approve_status'] = AdminVideoStatusModel::WAIT_APPROVED;
		AdminVideoStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO VIDEO
		$c = new CDbCriteria();
		$c->addInCondition("id", $videoList);
		$attributes = array('approved_by'=>0,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminVideoModel::model()->updateAll($attributes,$c);
	}

	public function setReconvert($videoList=array())
	{
		//UPDATE TO VIDEO_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $videoList);
		$attributes['convert_status'] = AdminVideoStatusModel::NOT_CONVERT;
		AdminVideoStatusModel::model()->updateAll($attributes,$c);

		//UPDATE CONVERT_VIDEO
		$c = new CDbCriteria();
		$c->addInCondition("video_id", $videoList);
		$attributes['status'] = AdminVideoStatusModel::NOT_CONVERT;
		AdminConvertVideoModel::model()->updateAll($attributes,$c);

		//UPDATE TO VIDEO
		$c = new CDbCriteria();
		$c->addInCondition("id", $videoList);
		$attributes = array('approved_by'=>0,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminVideoModel::model()->updateAll($attributes,$c);
	}

	public function checkpermision($videoId,$cpId)
	{
		if($cpId == 0) return true;
		$video = self::model()->findByPk($videoId);
		if(isset($video) && $video->cp_id == $cpId){
			return true;
		}
		return false;
	}

	public function search($lyric_filter = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = "t.id DESC ";

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.code',$this->code);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.url_key',$this->url_key,true);
		$criteria->compare('t.duration',$this->duration);
		$criteria->compare('t.song_id',$this->song_id,true);
//		$criteria->compare('t.genre_id',$this->genre_id);
		$criteria->compare('t.composer_id',$this->composer_id);
		$criteria->compare('t.artist_name',$this->artist_name,true);
		$criteria->compare('t.created_by',$this->created_by);
		$criteria->compare('t.approved_by',$this->approved_by);
		$criteria->compare('t.updated_by',$this->updated_by);
		$criteria->compare('t.cp_id',$this->cp_id);
		$criteria->compare('t.source_path',$this->source_path,true);
		$criteria->compare('t.download_price',$this->download_price);
		$criteria->compare('t.listen_price',$this->listen_price);
		$criteria->compare('t.max_bitrate',$this->max_bitrate);
		//$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('t.updated_time',$this->updated_time,true);
        $criteria->compare('t.sync_status',$this->sync_status);
		$criteria->compare('t.sorder',$this->sorder);
		//$criteria->compare('status',$this->status);
		if(!empty($this->created_time)){
			$criteria->addBetweenCondition('t.created_time',$this->created_time[0],$this->created_time[1]);
		}

        if(isset($this->genre_id) && $this->genre_id){
            $genreModel = GenreModel::model()->findByPk($this->genre_id);
            if($genreModel->parent_id == 0){
                $crite = new CDbCriteria;
                $crite->condition = "id = {$this->genre_id} OR parent_id = {$this->genre_id} AND status = ". VideoModel::ACTIVE;
                $childGenres = GenreModel::model()->findAll($crite);
                $genre_ids = array();
                foreach($childGenres as $childGenre)
                    $genre_ids[] = $childGenre->id;
                if(count($genre_ids)){
                    $genre_ids = implode(',',$genre_ids);
                    $criteria->addCondition("genre_id IN ($genre_ids)");
                }
                else
                    $criteria->addCondition("genre_id={$this->genre_id}");
            }else{
                $criteria->addCondition("genre_id={$this->genre_id}");
            }
        }
		$criteria->join = "INNER JOIN video_status vt ON t.id = vt.video_id";
        $joinWith = array();
        $joinWith[] = 'videoextra';
        $joinWith[] = 'video_statistic';
        $joinWith[] = 'genre';
        $joinWith[] = 'cp';
        if($lyric_filter && $this->lyric != 2){

            if($this->lyric)
                $ct = "videoextra.description <> ''";
            else
                $ct = "videoextra.description = ''";
            $criteria->addCondition($ct);
        }

		switch ($this->status){
			case self::NOT_CONVERT:
                if(!isset($this->status)){
                    $condition = "vt.approve_status <> ".AdminVideoStatusModel::REJECT;
                    break;
                }
				$condition = "vt.convert_status = ".AdminVideoStatusModel::NOT_CONVERT;
				$condition .= " AND vt.approve_status <> ".AdminVideoStatusModel::REJECT;
				break;
			case self::CONVERT_FAIL:
				$condition = "vt.convert_status = ".AdminVideoStatusModel::CONVERT_FAIL;
				$condition .= " AND vt.approve_status <> ".AdminVideoStatusModel::REJECT;
				break;
			case self::WAIT_APPROVED:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::WAIT_APPROVED;
				$condition .= " AND vt.convert_status = ".AdminVideoStatusModel::CONVERT_SUCCESS;
				break;
			case self::ACTIVE:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::APPROVED
									." AND vt.convert_status = ".AdminVideoStatusModel::CONVERT_SUCCESS
									." AND vt.artist_status = ".AdminVideoStatusModel::ARTIST_PUBLISH ;
				break;
			case self::DELETED:
				$condition = "vt.approve_status = ".AdminVideoStatusModel::REJECT
								." OR vt.approve_status = ".AdminVideoStatusModel::DELETED;
				break;
			case self::ALL:
			default:
				$condition = "vt.approve_status <> ".AdminVideoStatusModel::REJECT;
				break;
		}

		$criteria->addCondition($condition);
        //if(count($joinWith)>0)
        $criteria->with = $joinWith;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.updated_time DESC'),
			'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
	
	public function simpleSearch($genreId = null, $pagesize = null)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.status',$this->status,true);
		$criteria->compare('t.artist_name',$this->artist_name,true);
		$criteria->compare('t.cp_id',$this->cp_id);
		/*
		if(!empty($this->genre_id) && empty($this->genre_id_2)){
			$genreId = $this->genre_id;
		}
		*/
		
		$criteriaJoin = "";
		if($genreId){
			//$conditi = " t.genre_id = $genreId OR t.genre_id_2 = $genreId";
			//$criteria->addCondition($conditi);
			//$criteriaJoin = "INNER JOIN video_genre sc ON t.id = sc.video_id ";
			//$condition = " sc.genre_id = $genreId";
			//$criteria->addCondition($condition);
			$criteria->compare('t.genre_id',$genreId);
		}
		//$criteria->join = $criteriaJoin." INNER JOIN video_status st ON t.id = st.video_id";
		//$condition = "st.artist_status = ".AdminVideoStatusModel::ARTIST_PUBLISH ;
		//$criteria->addCondition($condition);
		
		//echo "<pre>"; print_r($criteria); echo "</pre>"; die();
                
                if(!isset($pagesize))
                    $pagesize = Yii::app()->params['pageSize'];
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort' => array('defaultOrder' => 't.created_time DESC, t.updated_time DESC'),
				'pagination'=>array(
                                'pageSize'=> $pagesize,
                        ),
		));
	}

}