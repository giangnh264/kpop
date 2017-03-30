<?php

class SongArtistModel extends BaseSongArtistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongArtist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function updateArtist($songId,$cats=array())
	{
		$conds = "song_id='{$songId}'";
		self::model()->deleteAll($conds);
		$i=0;
		foreach($cats as $cat){
			$i++;
			$artistObj =ArtistModel::model()->findByPk($cat);
			$songArtist = new self();
			$songArtist->song_id = $songId;
			$songArtist->artist_id = $cat;
			$songArtist->artist_name = $artistObj->name;
			$songArtist->ordering = $i;
			$songArtist->save();
		}
	}

	public function getArtistBySong($songId,$feild=false)
	{
		$c = new CDbCriteria();
		$c->condition = "song_id=:ID";
		$c->params = array(':ID'=>$songId);
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