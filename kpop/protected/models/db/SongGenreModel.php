<?php

class SongGenreModel extends BaseSongGenreModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongGenre the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCatBySong($songId,$getCatNames = false,$getCatId = false)
	{
		$c = new CDbCriteria();
		$c->condition = "song_id=:ID";
		$c->params = array(':ID'=>$songId);
		$result = self::model()->findAll($c);
		if($getCatNames){
			$i=0;
			$cateName = "";
			foreach($result as $cat){
				if($i>0){
					$cateName .= ", ";
				}
				$cateName .= $cat->genre_name;
				$i++;
			}
			return $cateName;
		}
        else if($getCatId)
        {
            $arrCatId = array();
            foreach($result as $cat){
				$arrCatId[] = $cat->genre_id;
			}
			return $arrCatId;
        }
		return $result;
	}

	public function updateSongCate($songId,$cats=array())
	{
		$conds = "song_id='{$songId}'";
		self::model()->deleteAll($conds);
        $catName = array();
		foreach($cats as $cat){
			$genreName = GenreModel::model()->findByPk($cat)->name;
			
			$sql = "INSERT INTO song_genre VALUES (:song_id,:genre_id,:genre_name)
					ON DUPLICATE KEY UPDATE genre_name=:genre_name
					";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(":song_id", $songId,PDO::PARAM_INT);
			$command->bindParam(":genre_id", $cat,PDO::PARAM_INT);
			$command->bindParam(":genre_name", $genreName,PDO::PARAM_INT);
			$command->execute();
			
			/* $songCat = new self();
			$songCat->song_id = $songId;
			$songCat->genre_id = $cat;
			$songCat->genre_name = GenreModel::model()->findByPk($cat)->name;
			$songCat->save(); */
		}
	}

	/*
	 * Update nhieu bai hat ve cung 1 the loai
	 * */
	public function massUpdateSong($songList=array(),$catId)
	{
		$conds = "song_id IN (".implode(",", $songList).")";
		self::model()->deleteAll($conds);

		$catName = AdminGenreModel::model()->findByPk($catId)->name;
		foreach($songList as $songId){
			$songCat = new self();
			$songCat->song_id = $songId;
			$songCat->genre_id = $catId;
			$songCat->genre_name = $catName;
			$songCat->save();
		}
	}

}