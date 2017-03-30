<?php

class VideoArtistModel extends BaseVideoArtistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoArtist the static model class
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
        
	public function updateArtist($videoId,$cats=array())
	{
		$conds = "video_id='{$videoId}'";
		self::model()->deleteAll($conds);
		$i=0;
		foreach($cats as $cat){
			$i++;
			$artistObj =ArtistModel::model()->findByPk($cat);
			$videoArtist = new self();
			$videoArtist->video_id = $videoId;
			$videoArtist->artist_id = $cat;
			$videoArtist->artist_name = $artistObj->name;
			$videoArtist->ordering = $i;
			$videoArtist->save();
		}
	}

	public function getArtistByVideo($videoId,$feild=false)
	{
		$c = new CDbCriteria();
		$c->condition = "video_id=:ID";
		$c->params = array(':ID'=>$videoId);
		$c->order = "ordering ASC";
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

}