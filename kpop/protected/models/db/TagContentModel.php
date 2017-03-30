<?php

class TagContentModel extends BaseTagContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TagContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations()
	{
		return array(
				"tag"	=> array(self::BELONGS_TO, "TagModel", "tag_id", 'joinType'=>'INNER JOIN'),
				"album"	=> array(self::BELONGS_TO, "AlbumModel", "content_id", "alias"=>"album", 'joinType'=>'INNER JOIN',"condition" => "album.status=1"),
				"video"	=> array(self::BELONGS_TO, "VideoModel", "content_id", "alias"=>"video", 'joinType'=>'INNER JOIN',"condition" => "video.status=1"),
				"song"	=> array(self::BELONGS_TO, "SongModel", "content_id", "alias"=>"song", 'joinType'=>'INNER JOIN',"condition" => "song.status=1"),
		);
	}
	
	public function getTagByContent($contentID, $contentType="song")
	{
		$c = new CDbCriteria();
		$c->condition = "content_id=:CID AND content_type=:TYPE";
		$c->params = array(":CID"=>$contentID,":TYPE"=>$contentType);
		return self::model()->findAll($c);
	}
	
	public function updateTag($contentId, $tagList = array(), $contentType = "song")
	{
		//Xoa het cac tag cu
		$sql = "DELETE  FROM tag_content WHERE content_id=:CID AND content_type=:TYPE";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(":CID",$contentId,PDO::PARAM_INT);
		$command->bindParam(":TYPE",$contentType,PDO::PARAM_STR);
		$command->execute();
	
		//Tao tag moi
		foreach($tagList as $tag){
			$tagName = TagModel::model()->findByPk($tag)->name;
			$sql = "INSERT INTO tag_content VALUES (:CID,:TYPE,:TID,:TNAME)
				ON DUPLICATE KEY UPDATE tag_name=:TNAME";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(":CID",$contentId,PDO::PARAM_INT);
			$command->bindParam(":TID",$tag,PDO::PARAM_INT);
			$command->bindParam(":TNAME",$tagName,PDO::PARAM_STR);
			$command->bindParam(":TYPE",$contentType,PDO::PARAM_STR);
			$command->execute();
		}
	}
	
	public function getContentByTag($tagId,$contentType="album", $limit=10)
	{
		$c = new CDbCriteria();
		$c->condition = "tag_id=:TAGID AND content_type=:CTYPE";
		$c->params = array(":TAGID"=>$tagId,":CTYPE"=>$contentType);
		$c->limit = $limit;
				
		$data = self::model()->with($contentType)->findAll($c);
		$return = array();
		foreach ($data as $item){
			$return[] = $item->$contentType;
		}
		return $return;
	}

	public function countContentBySameTag($topContentId='',$contentType,$tagId){
		$c = new CDbCriteria();
		$c->condition = "tag_id =:tagId AND content_type = :contentType";

		if(!empty($topContentId)){
			$c->condition .= " AND content_id <> :topContentId";
			$c->params = array(
				':tagId' => $tagId,
				':contentType' => $contentType,
				':topContentId' => $topContentId
			);
		}else{
			$c->params = array(
				':tagId' => $tagId,
				':contentType' => $contentType
			);
		}

		return TagContentModel::model()->count($c);
	}

	public function getContentBySameTag($topContentId='',$contentType,$tagId, $offset=0,$limit=10){
		$c = new CDbCriteria();
		$c->condition = "tag_id =:tagId AND content_type = :contentType";

		if(!empty($topContentId)){
			$c->condition .= " AND content_id <> :topContentId";
			$c->params = array(
				':tagId' => $tagId,
				':contentType' => $contentType,
				':topContentId' => $topContentId
			);
		}else{
			$c->params = array(
				':tagId' => $tagId,
				':contentType' => $contentType
			);
		}

		$c->limit 	= $limit;
		$c->offset 	= $offset;

		return TagContentModel::model()->findAll($c);
	}
}