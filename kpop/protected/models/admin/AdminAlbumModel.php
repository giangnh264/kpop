<?php

Yii::import('application.models.db.AlbumModel');

class AdminAlbumModel extends AlbumModel
{
	const ALL = -1;
	const WAIT_APPROVED = 0;
	const ACTIVE = 1;
	const DELETED = 2;

	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave() {
		if(!$this->url_key) $this->url_key = Common::url_friendly($this->name);
		if(!$this->updated_time || $this->updated_time == "" ) $this->updated_time = date("Y-m-d H:i:s");
		return parent::beforeSave();
	}

	public function relations()
	{
		return  CMap::mergeArray( parent::relations(),   array(
            'genre'=>array(self::BELONGS_TO, 'AdminGenreModel', 'genre_id', 'select'=>'id, name'),
			'user'=>array(self::BELONGS_TO, 'AdminAdminUserModel', 'created_by', 'select'=>'id, username', 'joinType'=>'LEFT JOIN'),
			'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name', 'joinType'=>'LEFT JOIN'),
			'albumstatus'=>array(self::HAS_ONE, 'AdminAlbumStatusModel', 'album_id', 'joinType'=>'LEFT JOIN'),
		));
	}

	public function setDelete($adminId, $reason, $albumList = array())
	{
		//UPDATE ALBUM_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("album_id", $albumList);
		$attributes['approve_status'] = AdminAlbumStatusModel::REJECT;
		AdminAlbumStatusModel::model()->updateAll($attributes,$c);

		// INSERT TO ALBUM_DELETE
		$albumDeleteList = AdminAlbumDeletedModel::model()->findAll();
		$albumDeleteList = CHtml::listData($albumDeleteList, "album_id", "album_id");
		$j=0;
		for($i=0; $i<count($albumList); $i++){
			if(!in_array($albumList[$i], $albumDeleteList)){
				 $albumDel = new AdminAlbumDeletedModel();
				 $albumDel->album_id = $albumList[$i];
				 $albumDel->deleted_reason = $reason;
				 $albumDel->deleted_by = $adminId;
				 $albumDel->deleted_time = date("Y-m-d H:i:s");
				 $albumDel->save();
				 $j++;
			}
		}
		return $j;
	}

	public function restore($albumList = array())
	{
		// REMOVE  IN ALBUM_DELETE
		$conditionDelete = "album_id in (".implode(",", $albumList).")";
		AdminAlbumDeletedModel::model()->deleteAll($conditionDelete);

		//UPDATE STATUS IN ALBUM_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("album_id", $albumList);
		$attributes['approve_status'] = AdminAlbumStatusModel::WAIT_APPROVED;
		AdminAlbumStatusModel::model()->updateAll($attributes,$c);
		
		//UPDATE STATUS ALBUM
		if(count($albumList)>0){
			$c = new CDbCriteria();
			$c->addInCondition("id", $albumList);
			$attributes['status'] = AdminAlbumModel::WAIT_APPROVED;
			AdminAlbumModel::model()->updateAll($attributes,$c);
		}
	}

	public function setApproved($albumList=array(),$adminId=null)
	{
		//UPDATE TO ALBUM_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("album_id", $albumList);
		$attributes['approve_status'] = AdminAlbumStatusModel::APPROVED;
		AdminAlbumStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO ALBUM
		$c = new CDbCriteria();
		$c->addInCondition("id", $albumList);
		$attributes = array('approved_by'=>$adminId,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"), 'status'=>1);
		AdminAlbumModel::model()->updateAll($attributes,$c);
	}

	public function setWaitApproved($albumList=array(),$adminId=null)
	{
		//UPDATE TO ALBUM_STATUS
		$c = new CDbCriteria();
		$c->addInCondition("album_id", $albumList);
		$attributes['approve_status'] = AdminAlbumStatusModel::WAIT_APPROVED;
		AdminAlbumStatusModel::model()->updateAll($attributes,$c);

		//UPDATE TO SONG
		$c = new CDbCriteria();
		$c->addInCondition("id", $albumList);
		$attributes = array('approved_by'=>0,'updated_by'=>$adminId,'updated_time'=>date("Y-m-d H:i:s"));
		AdminAlbumModel::model()->updateAll($attributes,$c);
	}


	public function massupdate($data,$listAlbum=array()){

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

		$c = new CDbCriteria();
		$c->condition = "id IN(".implode(",", $listAlbum).")";
		if(!empty($attributes)){
			$attributes['updated_time'] = date("Y-m-d H:i:s");
		  	self::model()->updateAll($attributes,$c);
		  	return count($listAlbum);
		}
		return 0;
	}

	public function updateTotalSong($albumId)
	{
		$c = new CDbCriteria();
		$c->condition = "album_id=:ID";
		$c->params = array(":ID"=>$albumId);
		$count = AdminAlbumSongModel::model()->count($c);
		$albumModel = self::model()->findByPk($albumId);
		$albumModel->song_count = $count;
		if(!$albumModel->save()){
			echo "<pre>";print_r($albumModel->getErrors());exit();
		}
	}

	public function getListByStatus($status,$cpId=0)
	{
		$criteria=new CDbCriteria;
		$criteria->join = "INNER JOIN album_status st ON t.id = st.album_id";

		switch ($status){
			case self::WAIT_APPROVED:
                if(!isset($status)){
                    $criteria->condition = "st.approve_status <> ".AdminAlbumStatusModel::REJECT;
                    break;
                }
				$criteria->condition = "st.approve_status = ".AdminAlbumStatusModel::WAIT_APPROVED;
				break;
			case self::ACTIVE:
				$criteria->condition = "st.approve_status = ".AdminAlbumStatusModel::APPROVED
									." AND st.artist_status = ".AdminAlbumStatusModel::ARTIST_PUBLISH ;
				break;
			case self::DELETED:
				$criteria->condition = "st.approve_status = ".AdminAlbumStatusModel::REJECT;
				break;
			case self::ALL:
			default:
				$criteria->condition = "st.approve_status <> ".AdminAlbumStatusModel::REJECT;
				break;
		}
		if(isset($cpId) && $cpId != 0){
			$criteria->addCondition("t.cp_id='{$cpId}'");
		}
		$criteria->order = "t.id DESC";
		return self::model()->findAll($criteria);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.url_key',$this->url_key,true);
		$criteria->compare('t.genre_id',$this->genre_id);
		$criteria->compare('t.artist_id',$this->artist_id,true);
		$criteria->compare('t.artist_name',$this->artist_name,true);
		$criteria->compare('t.song_count',$this->song_count);
		$criteria->compare('t.publisher',$this->publisher,true);
		$criteria->compare('t.published_date',$this->published_date,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.created_by',$this->created_by);
		$criteria->compare('t.approved_by',$this->approved_by);
		$criteria->compare('t.updated_by',$this->updated_by);
		$criteria->compare('t.cp_id',$this->cp_id);
		$criteria->compare('t.created_time',$this->created_time,true);
		$criteria->compare('t.updated_time',$this->updated_time,true);
		$criteria->compare('t.sorder',$this->sorder);
		//$criteria->compare('status',$this->status);

		$criteria->join = "INNER JOIN album_status st ON t.id = st.album_id";
		switch ($this->status){
			case self::WAIT_APPROVED:
				$condition = "t.status = ".self::WAIT_APPROVED." AND st.approve_status=".AdminAlbumStatusModel::WAIT_APPROVED;
				break;
			/* case self::ACTIVE:
				$condition = "st.approve_status = ".AdminAlbumStatusModel::APPROVED
									." AND st.artist_status = ".AdminAlbumStatusModel::ARTIST_PUBLISH ;
				break; */
			case self::ACTIVE:
				$condition = "t.status = ".self::ACTIVE;
				break;
			case self::DELETED:
				$condition = "st.approve_status = ".AdminAlbumStatusModel::REJECT." AND t.status=".self::WAIT_APPROVED;
				break;
			case self::ALL:
			default:
				$condition = " TRUE ";
				break;
		}
		if (isset($_GET['description']) && $_GET['description']>0) {
			if($_GET['description']==1){
				$condition = "t.description<>''";
			}else{
				$condition = "t.description=''";
			}
		}
		
		$criteria->addCondition($condition);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
			'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
}