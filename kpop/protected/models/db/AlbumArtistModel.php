<?php

class AlbumArtistModel extends BaseAlbumArtistModel
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return AlbumArtist the static model class
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
	
	public function updateArtist($albumId,$cats=array())
	{
		$conds = "album_id='{$albumId}'";
		self::model()->deleteAll($conds);
		foreach($cats as $cat){
			$artistObj =ArtistModel::model()->findByPk($cat);
			$albumArtist = new self();
			$albumArtist->album_id = $albumId;
			$albumArtist->artist_id = $cat;
			$albumArtist->artist_name = $artistObj->name;
			$albumArtist->save();
		}
	}
	
	public function getArtistByAlbum($albumId,$feild=false)
	{
		$c = new CDbCriteria();
		$c->condition = "album_id=:ID";
		$c->params = array(':ID'=>$albumId);
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
	
	public function getArtistsByAlbum($albumId) {
		$data = array();
		$cr = new CDbCriteria();
		$cr->condition = "album_id=:album_id";
		$cr->params = array(":album_id" => $albumId);
	
		$data = AlbumArtistModel::model()->with("artist")->findAll($cr);
		 
		return $data;
	}
	public function countAlbumByArtist($artist_id){
		$c = new CDbCriteria;
		$c->condition = "artist_id = :AID";
		$c->params = array(':AID'=>$artist_id);
		return AlbumArtistModel::model()->count($c);
	}
        
        public function getAlbumByArtist($artist_id, $limit){
                $c = new CDbCriteria;
		$c->condition = "artist_id = :AID";
		$c->params = array(':AID'=>$artist_id);
                $c->limit = $limit;
		return AlbumArtistModel::model()->findAll($c);
        }
}