<?php

Yii::import('application.models.db.ArtistModel');

class AdminArtistModel extends ArtistModel
{
	const ALL = -1;
	const ENABLE = 1;
	const DISABLE = 0;
	const DELETE = 2;
	var $className = __CLASS__;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave() {
		if(!$this->url_key) $this->url_key = Common::url_friendly($this->name);
		return parent::beforeSave();
	}
	 
	
	/*Update total song*/
	public function updateTotalSongById($artistId)
	{
		$c = new CDbCriteria();
		$c->condition = "status=:STATUS AND artist_id=:ARTIST";
		$c->params = array(':STATUS'=>AdminSongModel::ACTIVE,':ARTIST'=>$artistId);
		$count = AdminSongModel::model()->count($c);
		
		$artist = self::model()->findByPk($artistId);
		if(!empty($artist)){
			$artist->song_count = $count;
			$artist->save();
		}
		
	}
	public function updateTotalSongBySongList($songList = array())
	{
		$c = new CDbCriteria();
		$c->group = "artist_id";
		$c->condition = "id IN (".implode(",", $songList).")";
		$song = AdminSongModel::model()->findAll($c);
		foreach ($song as $song){
			$this->updateTotalSongById($song->artist_id);
		}
	}
	
	/*Update total video*/
	public function updateTotalVideoById($artistId)
	{
		$c = new CDbCriteria();
		$c->condition = "status=:STATUS AND artist_id=:ARTIST";
		$c->params = array(':STATUS'=>AdminVideoModel::ACTIVE,':ARTIST'=>$artistId);
		$count = AdminVideoModel::model()->count($c);
		
		$artist = self::model()->findByPk($artistId);
		if(!empty($artist)){
			$artist->video_count = $count;
			$artist->save();
		}
	}
	public function updateTotalVideoBySongList($videoList = array())
	{
		$c = new CDbCriteria();
		$c->group = "artist_id";
		$c->condition = "id IN (".implode(",", $videoList).")";
		$song = AdminVideoModel::model()->findAll($c);
		foreach ($song as $song){
			$this->updateTotalVideoById($song->artist_id);
		}
	}
	
	/* Update total album*/
	public function updateTotalAlbumById($artistId)
	{
		$c = new CDbCriteria();
		$c->condition = "status=:STATUS AND artist_id=:ARTIST";
		$c->params = array(':STATUS'=>AdminAlbumModel::ACTIVE,':ARTIST'=>$artistId);
		$count = AdminAlbumModel::model()->count($c);
		$artist = self::model()->findByPk($artistId);
		if(!empty($artist)){
			$artist->album_count = $count;
			$artist->save();
		}
	}
	public function updateTotalAlbumByAlbumList($albumList=array())
	{
		$c = new CDbCriteria();
		$c->group = "artist_id";
		$c->condition = "id IN (".implode(",", $albumList).")";
		$album = AdminAlbumModel::model()->findAll($c);
		foreach ($album as $album){
			$this->updateTotalAlbumById($album->artist_id);
		}
	}
	
	public function updateStatus($artistId,$status)
	{
		$sql = "UPDATE 
					song, song_status SET song_status.artist_status='{$status}' 
				WHERE song_status.song_id=song.id AND song.artist_id='{$artistId}'";
		Yii::app()->db->createCommand($sql)->execute();
		
		$sql = "UPDATE 
					video, video_status 
				SET 
					video_status.artist_status='{$status}'  
				WHERE 
					video_status.video_id=video.id AND video.artist_id='{$artistId}'";
		Yii::app()->db->createCommand($sql)->execute();
		
		$sql = "UPDATE 
					album, album_status 
				SET 
					album_status.artist_status='{$status}' 
				WHERE 
					album_status.album_id=album.id AND album.artist_id='{$artistId}'";
		Yii::app()->db->createCommand($sql)->execute();
	}
	public function search($joinRbt="")
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
		$criteria->alias = 't';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('song_count',$this->song_count,true);
		$criteria->compare('video_count',$this->video_count,true);
		$criteria->compare('album_count',$this->album_count,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('artist_type_id',$this->artist_type_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.artist_key',$this->artist_key);
		if (isset($_GET['description']) && $_GET['description']>0) {
			if($_GET['description']==1){
				$criteria->condition = "description<>''";
			}else{
				$criteria->condition = "description=''";
			}
		}
		
		$criteria->order = "t.name ASC";
		if(isset($joinRbt))
		{
			if($joinRbt == 1){
				$criteria->addCondition(" EXISTS (select * from rbt where rbt.artist_id = t.id) ");
			}
			if($joinRbt == -1){
				$criteria->addCondition(" NOT EXISTS (select * from rbt where rbt.artist_id = t.id) ");
	
				//                        $criteria->join = "LEFT JOIN rbt ON t.id = rbt.artist_id";
				//                        $criteria->addCondition("rbt.artist_id = 0 OR rbt.artist_id IS NULL");
			}
		}
	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
				),
		));
	}
}