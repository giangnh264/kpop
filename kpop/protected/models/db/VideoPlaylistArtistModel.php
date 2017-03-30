<?php

class VideoPlaylistArtistModel extends BaseVideoPlaylistArtistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoPlaylistArtist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations() {
		return CMap::mergeArray(parent::relations(), array(
				"artist" => array(self::BELONGS_TO, "ArtistModel", "artist_id"),
		));
	}	
	
	public function updateArtist($videoPlaylistId,$cats=array())
	{
		$conds = "video_playlist_id='{$videoPlaylistId}'";
		self::model()->deleteAll($conds);
		foreach($cats as $cat){
			$artistObj =ArtistModel::model()->findByPk($cat);
			$videoPlaylistArtist = new self();
			$videoPlaylistArtist->video_playlist_id = $videoPlaylistId;
			$videoPlaylistArtist->artist_id = $cat;
			$videoPlaylistArtist->artist_name = $artistObj->name;
			$videoPlaylistArtist->save();
		}
	}
	
	public function getArtistByVideoPlaylist($videoPlaylistId,$feild=false)
	{
		$c = new CDbCriteria();
		$c->condition = "video_playlist_id=:ID";
		$c->params = array(':ID'=>$videoPlaylistId);
		$result = self::model()->findAll($c);
		if('name'==$feild){
			$i=0;
			$name = "";
			foreach($result as $cat){
				if($i>0){
					$name .= ", ";
				}
				$name .= $cat->artist_name;
				$i++;
			}
			return $name;
		}
		else if('id'==$feild) {
			$arrId = array();
			foreach($result as $cat){
				$arrId[] = $cat->artist_id;
			}
			return $arrId;
		}
		return $result;
	}
	
	public function getArtistsByVideoPlaylist($videoPlaylistId) {
		$data = array();
		$cr = new CDbCriteria();
		$cr->condition = "video_playlist_id=:video_playlist_id";
		$cr->params = array(":video_playlist_id" => $videoPlaylistId);
	
		$data = VideoPlaylistArtistModel::model()->with("artist")->findAll($cr);
		 
		return $data;
	}
	public function countVideoPlaylistByArtist($artist_id){
		$c = new CDbCriteria;
		$c->condition = "artist_id = :AID";
		$c->params = array(':AID'=>$artist_id);
		return VideoPlaylistArtistModel::model()->count($c);
	}
        
        public function delete($videoPlaylistIdList = array())
	{
            //delete record from video_playlist_artist
            $c = new CDbCriteria();
            $c->addInCondition("video_playlist_id", $videoPlaylistIdList);
            self::model()->deleteAll($c);
	}
}