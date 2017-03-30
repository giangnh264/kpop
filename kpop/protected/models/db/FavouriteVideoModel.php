<?php
class FavouriteVideoModel extends BaseFavouriteVideoModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FavouriteVideo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
            public function relations(){
		return CMap::mergeArray(parent::relations(), array(
			#"video"		=> array(self::BELONGS_TO, "VideoModel", "video_id"),
                        #'video'=>array(self::BELONGS_TO, 'VideoModel', 'video_id', 'select'=>'*', 'alias'=> 'video', 'joinType'=>'INNER JOIN'),
		));
	}
}