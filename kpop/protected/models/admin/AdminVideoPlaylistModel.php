<?php

Yii::import('application.models.db.VideoPlaylistModel');

class AdminVideoPlaylistModel extends VideoPlaylistModel
{
        const ALL = -1;
	const WAIT_APPROVED = 0;
	const APPROVED = 1;
	const REJECT = 2;
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
			//'videoPlayliststatus'=>array(self::HAS_ONE, 'AdminVideoPlaylistStatusModel', 'video_playlist_id', 'joinType'=>'LEFT JOIN'),
		));
	}

	public function delete($videoPlaylistIdList = array())
	{
            //delete all relative data to this id
            AdminVideoPlaylistArtistModel::model()->delete($videoPlaylistIdList);
            AdminVideoPlaylistVideoModel::model()->delete($videoPlaylistIdList);
            
            //delete record from video_playlist_artist
            $c = new CDbCriteria();
            $c->addInCondition("id", $videoPlaylistIdList);
            return self::model()->deleteAll($c);
	}
        
        public function updateTotalVideo($videoPlaylistId)
	{
		$c = new CDbCriteria();
		$c->condition = "video_playlist_id=:ID";
		$c->params = array(":ID"=>$videoPlaylistId);
		$count = AdminVideoPlaylistVideoModel::model()->count($c);
		$videoPlaylistModel = self::model()->findByPk($videoPlaylistId);
		$videoPlaylistModel->video_count = $count;
		if(!$videoPlaylistModel->save()){
			echo "<pre>";print_r($videoPlaylistModel->getErrors());exit();
		}
	}

	public function getListByStatus($status,$cpId=0)
	{
		$criteria=new CDbCriteria;

		switch ($status){
			case self::WAIT_APPROVED:
				
                if(!isset($status)){
                    //$criteria->condition = "st.approve_status <> ".AdminVideoPlaylistStatusModel::REJECT;
                	$criteria->condition = "t.status = ".self::WAIT_APPROVED;
                    break;
                }
				$criteria->condition = "t.status = ".self::WAIT_APPROVED;
				break;
			case self::ACTIVE:
				/*
				$criteria->condition = "st.approve_status = ".AdminVideoPlaylistStatusModel::APPROVED
									." AND st.artist_status = ".AdminVideoPlaylistStatusModel::ARTIST_PUBLISH ;
									*/
				$criteria->condition = "t.status = ".self::ACTIVE;
				break;
			case self::DELETED:
				//$criteria->condition = "st.approve_status = ".AdminVideoPlaylistStatusModel::REJECT;
				$condition = " t.status=".self::DELETED;
				break;
			case self::ALL:
			default:
				//$criteria->condition = "st.approve_status <> ".AdminVideoPlaylistStatusModel::REJECT;
				$condition = " TRUE ";
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
		$criteria->compare('t.video_count',$this->video_count);
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
		//$criteria->compare('t.status',$this->status);
		
                $condition = '';
		if (isset($_GET['description']) && $_GET['description']>0) {
			if($_GET['description']==1){
				$condition = "t.description<>''";
			}else{
				$condition = "t.description=''";
			}
		}
                if(!empty($condition))
                    $criteria->addCondition($condition);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.status ASC, t.id DESC'),
			'pagination'=>array(
                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                        ),
		));
	}
}