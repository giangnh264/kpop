<?php

class SongCateModel extends BaseSongCateModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongCate the static model class
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
				$cateName .= $cat->cat_name;	
				$i++;	
			}
			return $cateName;
		}
        else if($getCatId)
        {
            $arrCatId = array();
            foreach($result as $cat){
				$arrCatId[] = $cat->cat_id;
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
			$songCat = new self();
			$songCat->song_id = $songId;
			$songCat->cat_id = $cat;
			$songCat->cat_name = AdminGenreModel::model()->findByPk($cat)->name;
            $catName[] = $songCat->cat_name ;
			$songCat->save();
		}
        $songModel = SongModel::model()->findByPk($songId);
        $songModel->genre_name = $catName[0];
        $songModel->genre_id = $cats[0];
        $songModel->save();
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
			$songCat->cat_id = $catId;
			$songCat->cat_name = $catName;
			$songCat->save();
		}
        $sql = "update song set genre_name = '$catName' where id in (".implode(",", $songList).")";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
	}
}